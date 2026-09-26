<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

#[Signature('rules:validate-cursor')]
#[Description('Validate .cursor/rules/*.mdc frontmatter and size limits')]
class ValidateCursorRulesCommand extends Command
{
    private const int MaxLines = 500;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $rulesDir = base_path('.cursor/rules');

        if (! is_dir($rulesDir)) {
            $this->error('Missing .cursor/rules directory.');

            return self::FAILURE;
        }

        $readme = $rulesDir.'/README.md';
        if (! is_file($readme)) {
            $this->error('Missing .cursor/rules/README.md index.');
        }

        $errors = [];
        $mdcFiles = [];

        foreach (Finder::create()->files()->in($rulesDir)->name('*.mdc') as $file) {
            $mdcFiles[] = $file->getFilename();
            $path = $file->getRealPath();
            $content = File::get($path);
            $lineCount = substr_count($content, "\n") + 1;

            if ($lineCount > self::MaxLines) {
                $errors[] = "{$file->getFilename()}: exceeds ".self::MaxLines." lines ({$lineCount}).";
            }

            if (! preg_match('/\A---\s*\n(.*?)\n---\s*\n/s', $content, $matches)) {
                $errors[] = "{$file->getFilename()}: missing YAML frontmatter.";

                continue;
            }

            $front = $matches[1];
            if (! preg_match('/^description:\s*.+/m', $front)) {
                $errors[] = "{$file->getFilename()}: frontmatter must include description.";
            }

            if (! preg_match('/^alwaysApply:\s*(true|false)\s*$/m', $front)) {
                $errors[] = "{$file->getFilename()}: frontmatter must include alwaysApply: true or false.";
            }
        }

        if ($mdcFiles === []) {
            $errors[] = 'No .mdc rule files found in .cursor/rules.';
        }

        sort($mdcFiles);
        if (is_file($readme)) {
            foreach ($mdcFiles as $mdc) {
                if ($mdc === 'rules-index.mdc') {
                    continue;
                }
                if (! str_contains(File::get($readme), $mdc)) {
                    $errors[] = "README.md does not mention {$mdc}.";
                }
            }
        }

        if ($errors !== []) {
            foreach ($errors as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $this->info('Validated '.count($mdcFiles).' Cursor rule file(s).');

        return self::SUCCESS;
    }
}
