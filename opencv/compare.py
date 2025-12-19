#!/usr/bin/env python3

import cv2
import numpy as np
import sys
from pathlib import Path

# -------------------------
# Argument parsing
# -------------------------
use_sift = False
args = sys.argv[1:]

if "--sift" in args:
    use_sift = True
    args.remove("--sift")

if len(args) < 2:
    print("Usage: compare.py [--sift] img1 img2 [output]")
    sys.exit(1)

img1_path = args[0]
img2_path = args[1]
out_path = args[2] if len(args) > 2 else "diff.png"

# -------------------------
# Load images
# -------------------------
img1 = cv2.imread(img1_path)
img2 = cv2.imread(img2_path)

if img1 is None or img2 is None:
    raise RuntimeError("Could not load one of the images")

g1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
g2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)

# -------------------------
# Feature detection (optimized for documents)
# -------------------------
if use_sift:
    detector = cv2.SIFT_create(
        nfeatures=5000, contrastThreshold=0.01, edgeThreshold=10, sigma=1.2
    )
    norm = cv2.NORM_L2
    algo_name = "SIFT"
else:
    detector = cv2.ORB_create(
        nfeatures=5000,
        scaleFactor=1.2,
        nlevels=8,
        edgeThreshold=15,
        patchSize=31,
        fastThreshold=5,
    )
    norm = cv2.NORM_HAMMING
    algo_name = "ORB"

kp1, des1 = detector.detectAndCompute(g1, None)
kp2, des2 = detector.detectAndCompute(g2, None)

if des1 is None or des2 is None:
    raise RuntimeError("No features detected")

# -------------------------
# Matching with kNN + ratio test
# -------------------------
bf = cv2.BFMatcher(norm)
knn_matches = bf.knnMatch(des1, des2, k=2)

# Lowe's ratio test
ratio_thresh = 0.75
good_matches = []
for m, n in knn_matches:
    if m.distance < ratio_thresh * n.distance:
        good_matches.append(m)

# -------------------------
# Optional: spatial displacement filtering
# -------------------------
MAX_SHIFT_PX = 200  # adjust for your document size
filtered_matches = []
for m in good_matches:
    p1 = np.array(kp1[m.queryIdx].pt)
    p2 = np.array(kp2[m.trainIdx].pt)
    if np.linalg.norm(p1 - p2) < MAX_SHIFT_PX:
        filtered_matches.append(m)

matches_to_use = filtered_matches

# -------------------------
# Visualization
# -------------------------
match_img = cv2.drawMatches(
    img1,
    kp1,
    img2,
    kp2,
    matches_to_use,
    None,
    flags=cv2.DrawMatchesFlags_NOT_DRAW_SINGLE_POINTS,
)
cv2.imwrite(out_path, match_img)

# -------------------------
# Metrics
# -------------------------
shifts = []
for m in matches_to_use:
    p1 = np.array(kp1[m.queryIdx].pt)
    p2 = np.array(kp2[m.trainIdx].pt)
    shifts.append(np.linalg.norm(p1 - p2))

avg_shift = float(np.mean(shifts)) if shifts else float("nan")

print(f"Algorithm: {algo_name}")
print(f"Matches after filtering: {len(matches_to_use)}")
print(f"Average feature displacement: {avg_shift:.2f} px")
print(f"Diff image written to: {out_path}")
