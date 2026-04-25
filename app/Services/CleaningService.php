<?php

namespace App\Services;

use App\Models\FileExtension;
use App\Models\FileRestriction;
use App\Models\Submission;
use App\Services\Cleaning\CleanCSSService;
use App\Services\Cleaning\CleanHTMLService;
use App\Services\Cleaning\CleanPHPService;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CleaningService
{
    private CleanHTMLService $cHTML;

    private CleanCSSService $cCSS;

    private CleanPHPService $cPHP;

    public function __construct()
    {
        $this->cHTML = new CleanHTMLService;
        $this->cCSS = new CleanCSSService;
        $this->cPHP = new CleanPHPService;
    }

    /**
     * @param  FileExtension[]  $extensions
     * @param  FileRestriction[]  $restrictions
     */
    public function cleanProject(Submission $submission, array $extensions, array $restrictions): string
    {
        $result = '';

        $zip = new ZipArchive;
        if ($zip->open($submission->getAbsolutePath()) !== true) {
            return $result;
        }

        $id = uniqid($submission->file_filename . '_', true);
        $localUrl = Storage::disk('tmp')->path($id);
        if (!$zip->extractTo($localUrl)) {
            $zip->close();
            return $result;
        }
        $zip->close();

        $ignoreDir = $this->getRestrict($restrictions, 'dir');
        $ignoreFile = $this->getRestrict($restrictions, 'file');
        $result = $this->processScan($localUrl, $extensions, $ignoreDir, $ignoreFile);

        Storage::disk('tmp')->deleteDirectory($id);

        return $result;
    }

    /**
     * @param  FileExtension[]  $extensions
     * @param  string[]  $ignoreDir
     * @param  string[]  $ignoreFile
     */
    function processScan(string $dir, array $extensions, array $ignoreDir, array $ignoreFile): string
    {
        $result = '';
        if (!is_dir($dir)) {
            return $result;
        }

        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path) && in_array($item, $ignoreDir, true)) {
                continue;
            }

            if (is_dir($path)) {
                $result .= $this->processScan($path, $extensions, $ignoreDir, $ignoreFile);
            } else if (
                is_file($path) && is_readable($path) &&
                $this->isOk($path, $extensions, $ignoreFile)
            ) {
                $result .= $this->cleanWithExtension(file_get_contents($path), $this->getExtension($path));
            }
        }
        return $result;
    }

    /**
     * @param  FileRestriction[]  $restrictions
     * @param  string  $fileType
     */
    public function getRestrict(array $restrictions, string $fileType): array
    {
        $result = [];
        foreach ($restrictions as $restriction) {
            if ($restriction->fileType->name == $fileType) {
                $result[] = $restriction->name;
            }
        }
        return $result;
    }

    public function cleanWithExtension(string $text, string $extension): string
    {
        switch ($extension) {
            case '.html':
                return $this->cHTML->clean($text);
            case '.css':
                return $this->cCSS->clean($text);
            case '.php':
                return $this->cPHP->clean($text);

            default:
                throw new \Exception('Unknown extension: ' . $extension, 1);
        }
    }

    public function getExtension(string $path): string
    {
        $parts = explode('.', $path);
        $result = end($parts);

        return ".{$result}";
    }

    /**
     * @param  FileExtension[]  $extensions
     * @param  string[]  $ignoreFile
     */
    public function isOk(string $path, array $extensions, array $ignoreFile): bool
    {
        $extOk = false;
        foreach ($extensions as $extension) {
            if (str_ends_with($path, $extension->extension)) {
                $extOk = true;
                break;
            }
        }
        if (!$extOk) {
            return false;
        }

        foreach ($ignoreFile as $ignore) {
            if (str_ends_with($path, $ignore)) {
                return false;
            }
        }

        return true;
    }

}
