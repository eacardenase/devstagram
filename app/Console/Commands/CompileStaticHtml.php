<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

class CompileStaticHtml extends Command
{
    protected $signature = 'compile:static-html';
    protected $description = 'Compile Blade templates to static HTML';

    public function handle()
    {
        $viewsPath = resource_path('views');
        $outputPath = public_path();

        $files = File::allFiles($viewsPath);

        foreach ($files as $file) {
            $viewName = $file->getRelativePathname();
            $html = Blade::compileString(file_get_contents($file));
            $htmlPath = $outputPath . '/' . pathinfo($viewName, PATHINFO_FILENAME) . '.html';
            File::put($htmlPath, $html);
        }

        $this->info('Static HTML files compiled successfully.');
    }
}
