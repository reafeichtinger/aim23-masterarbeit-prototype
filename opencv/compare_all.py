#!/usr/bin/env python3

import csv
import cv2
import numpy as np
import os
from pathlib import Path

RESULTS_ROOT = Path("/work/storage/app/public/results")
STATIC_ROOT = Path("/work/public/img")
CSV_PATH = Path("/work/storage/app/public/results/all_opencv_results.csv")

IMAGES = ["grapesjs.png", "ckeditor.png"]

ALGORITHMS = {
    "orb": {
        "detector": lambda: cv2.ORB_create(
            nfeatures=5120,
            scaleFactor=2,
            nlevels=12,
            edgeThreshold=0,
            patchSize=96,
            fastThreshold=96,
        ),
        "norm": cv2.NORM_HAMMING,
    },
    "sift": {
        "detector": lambda: cv2.SIFT_create(
            nfeatures=5120,
            contrastThreshold=0.15,
            edgeThreshold=15,
            sigma=5,
        ),
        "norm": cv2.NORM_L2,
    },
}


def compare_images(img1_path, img2_path, output_path, algo):
    img1 = cv2.imread(str(img1_path))
    img2 = cv2.imread(str(img2_path))

    if img1 is None or img2 is None:
        return 0, float("nan")

    g1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
    g2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)

    detector = ALGORITHMS[algo]["detector"]()
    norm = ALGORITHMS[algo]["norm"]

    kp1, des1 = detector.detectAndCompute(g1, None)
    kp2, des2 = detector.detectAndCompute(g2, None)

    if des1 is None or des2 is None:
        return 0, float("nan")

    bf = cv2.BFMatcher(norm, crossCheck=True)
    matches = bf.match(des1, des2)
    matches = sorted(matches, key=lambda m: m.distance)

    vis = cv2.drawMatches(
        img1,
        kp1,
        img2,
        kp2,
        matches,
        None,
        flags=cv2.DrawMatchesFlags_NOT_DRAW_SINGLE_POINTS,
    )

    cv2.imwrite(str(output_path), vis)

    shifts = []
    for m in matches:
        p1 = np.array(kp1[m.queryIdx].pt)
        p2 = np.array(kp2[m.trainIdx].pt)
        shifts.append(np.linalg.norm(p1 - p2))

    avg_shift = float(np.mean(shifts)) if shifts else float("nan")

    return len(matches), avg_shift


def main():
    if CSV_PATH.exists():
        os.remove(CSV_PATH)

    with CSV_PATH.open("a", newline="") as csvfile:
        writer = csv.writer(csvfile)

        writer.writerow(
            ["folder", "image", "algorithm", "matches", "avg_displacement_px"]
        )

        for folder in sorted(RESULTS_ROOT.iterdir()):
            if not folder.is_dir():
                continue

            for image_name in IMAGES:
                result_img = folder / image_name
                static_img = STATIC_ROOT / image_name

                if not result_img.exists() or not static_img.exists():
                    continue

                for algo in ALGORITHMS.keys():
                    out_name = image_name.replace(".png", f"_{algo}_diff.png")
                    out_path = folder / out_name

                    matches, avg_shift = compare_images(
                        result_img, static_img, out_path, algo
                    )

                    writer.writerow(
                        [
                            folder.name,
                            image_name,
                            algo,
                            matches,
                            f"{avg_shift:.2f}" if avg_shift == avg_shift else "",
                        ]
                    )

                    print(
                        f"{folder.name}/{image_name} [{algo}]: "
                        f"{matches} matches, "
                        f"{avg_shift:.2f}px"
                    )


if __name__ == "__main__":
    main()
