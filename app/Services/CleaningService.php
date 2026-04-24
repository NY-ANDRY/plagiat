<?php

namespace App\Services;

use App\Models\FileExtension;
use App\Models\FileRestriction;
use App\Models\Submission;
use App\Services\Cleaning\CleanCSSService;
use App\Services\Cleaning\CleanHTMLService;
use App\Services\Cleaning\CleanPHPService;
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

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            $path = $stat['name'];
            if ($stat === false || ! isset($path) || ! $this->isOk($path, $extensions, $restrictions)) {
                continue;
            }
            $content = $zip->getFromName($path);
            $content = $this->cleanWithExtension($content, $this->getExtension($path));
            $result .= $content;
        }
        $zip->close();

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
                throw new \Exception('Unknown extension: '.$extension, 1);
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
     * @param  FileRestriction[]  $restrictions
     */
    public function isOk(string $path, array $extensions, array $restrictions): bool
    {
        if (str_ends_with($path, '/')) {
            return false;
        }

        $extOk = false;
        foreach ($extensions as $extension) {
            if (str_ends_with($path, $extension['extension'])) {
                $extOk = true;
                break;
            }
        }
        if (! $extOk) {
            return false;
        }

        foreach ($restrictions as $restriction) {
            $okRestriction = true;
            switch ($restriction->fileType->name) {
                case 'dir':
                    $okRestriction = $this->okDir($path, $restriction->name);
                    break;

                case 'file':
                    $okRestriction = $this->okFile($path, $restriction->name);
                    break;
            }
            if (! $okRestriction) {
                return false;
            }
        }

        return true;
    }

    private function okDir(string $path, string $restrictionName): bool
    {
        $parts = explode('/', $path);
        foreach ($parts as $part) {
            if ($part == $restrictionName) {
                return false;
            }
        }

        return true;
    }

    private function okFile(string $path, string $restrictionName): bool
    {
        if (str_ends_with($path, $restrictionName)) {
            return false;
        }

        return true;
    }
}
