<?php

namespace App\Actions\OdiffResult;

use App\DTOs\OdiffResultData;
use App\Enums\EditorEnum;
use App\Models\TestRun;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class GenerateOdiffResultsAction
{
    public static array $config = [
        '_diff' => 'odiff "%s" "%s" "%s" --diff-mask --output-diff-lines --parsable-stdout --aa',
        '_diff_no_aa' => 'odiff "%s" "%s" "%s" --diff-mask',
        '_diff_no_mask' => 'odiff "%s" "%s" "%s" --aa',
        '_diff_no_mask_no_aa' => 'odiff "%s" "%s" "%s"',
        '_diff_switch_no_mask' => 'odiff "%s" "%s" "%s" --aa',
        '_diff_switch_no_mask_no_aa' => 'odiff "%s" "%s" "%s"',
    ];

    public static function handle(string $basePath, TestRun $testRun): void
    {
        foreach (EditorEnum::values() as $editor) {
            // Prepare data
            $input = "$basePath/$editor.png";
            $filename = Str::afterLast($input, '/');
            $template = public_path("img/$filename");

            // Run odiff with all configs
            foreach (static::$config as $extension => $command) {
                // Prepare command
                $output = str_replace('.png', "$extension.png", $input);
                $data = str_contains($extension, '_switch_') ? [$input, $template, $output] : [$template, $input, $output];

                // Run command
                $process = Process::fromShellCommandline(sprintf($command, ...$data));
                $process->run();

                // Get results and persist them only for the first odiff
                if ($extension === '_diff') {
                    $diff = explode(';', $process->getOutput());
                    SaveOdiffResultAction::handle(new OdiffResultData(
                        test_run: $testRun,
                        editor: str_contains($input, EditorEnum::CKEDITOR->value) ? EditorEnum::CKEDITOR : EditorEnum::GRAPESJS,
                        pixels: (int) ($diff[0] ?? 0),
                        percent: (float) ($diff[1] ?? 0.0),
                        lines: count(($diff[2] ?? null) ? explode(',', str_replace(PHP_EOL, '', ($diff[2] ?? ''))) : []),
                    ), $testRun->odiffResults->where('editor', $editor)->first());
                }
            }
        }
    }
}
