<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Enums\OutputFormat;
use Spatie\PdfToImage\Pdf;

class PdfToPng extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pdf-to-png 
                                {input : The path of the input pdf.}
                                {output : The path of the output png.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Turn a .pdf file into a .png image.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Read arguments
        $inputPath = $this->argument('input');
        $outputPath = $this->argument('output');

        // Parse absolute and relative paths
        $input = Str::startsWith($inputPath, '/') ? $inputPath : base_path($inputPath);
        $output = Str::startsWith($outputPath, '/') ? $outputPath : base_path($outputPath);

        // Check file extensions
        if (!Str::endsWith($input, 'pdf')) {
            $this->components->error('Input must be a ".pdf" file!');

            return Command::FAILURE;
        }
        if (!Str::endsWith($output, 'png')) {
            $this->components->error('Output must end with ".png"!');

            return Command::FAILURE;
        }

        // Check if input exists
        if (!file_exists($input) || !is_file($input)) {
            $this->components->error("File \"$input\" does not exist!");

            return Command::FAILURE;
        }

        // Check output valid
        $outputDir = Str::beforeLast($output, '/');
        if (file_exists($outputDir) && !is_dir($outputDir)) {
            // Output path is a file
            $this->components->error("Output \"$outputDir\" must be a valid directory!");

            return Command::FAILURE;
        } elseif (!file_exists($outputDir)) {
            // Create directory
            mkdir($outputDir);
        }

        // Convert to png
        $pdf = new Pdf($input);
        $result = $pdf->format(OutputFormat::Png)->save($output);
        $result = implode('", "', Arr::wrap($result));

        $this->components->success("Created output file(s) \"$result\"");

        return Command::SUCCESS;
    }
}
