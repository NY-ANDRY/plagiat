<?php

namespace App\Services;

use App\Interface\IProject;
use App\Models\FileExtension;
use App\Models\FileRestriction;
use ZipArchive;

class CleaningService
{

    private CleanHTMLService $cHTML;
    private CleanCSSService $cCSS;
    private CleanPHPService $cPHP;

    public function __construct()
    {
        $this->cHTML = new CleanHTMLService();
        $this->cCSS = new CleanCSSService();
        $this->cPHP = new CleanPHPService();
    }

    /**
     * @param  FileExtension[]  $extensions
     * @param  FileRestriction[]  $restriction
     */
    public function cleanProject(IProject $project, array $extensions, array $restriction): string
    {
        $result = '';

        $zip = new ZipArchive();
        if ($zip->open($project->getPathname()) !== true) {
            return $result;
        }

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            $path = $stat['name'];
            if ($stat === false || !isset($path) || !$this->isOk($path, $extensions, $restriction)) {
                continue;
            }
            $content = $zip->getFromName($path);
            $content = $this->cleanWithExtension($content, $this->getExtension($path));
            $result = "{$result}{$content}";
        }
        $zip->close();

        return $result;
    }

    public function cleanWithExtension(string $text, $extension): string
    {
        switch ($extension) {
            case '.html':
                return $this->cHTML->clean($text);
            case '.css':
                return $this->cCSS->clean($text);
            case '.php':
                return $this->cPHP->clean($text);

            default:
                throw new \Exception("Unknown extension", 1);
        }
    }

    public function getExtension($path)
    {
        $parts = explode('.', $path);
        $result = $parts[\count($parts) - 1];
        return ".{$result}";
    }

    /**
     * true: fichier manana extension anaty extension sy tsy anaty false eo ambany
     * 
     * false: fichier anaty restriction - fichier anaty folder anaty restriction -  folder fotsiny (miafara amin'ny /)
     * 
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
        if (!$extOk) {
            return false;
        }

        $okRestriction = true;
        foreach ($restrictions as $restriction) {
            switch ($restriction->fileType->name) {
                case 'dir':
                    $okRestriction = $this->okDir($path, $restriction->name);

                case 'file':
                    $okRestriction = $this->okFile($path, $restriction->name);
            }
            if (!$okRestriction) {
                return false;
            }
        }

        return true;
    }

    private function okDir($path, string $restrictions): bool
    {
        $parts = explode('/', $path);
        foreach ($parts as $part) {
            if ($part == $restrictions) {
                return false;
            }
        }
        return true;
    }

    private function okFile($path, string $restrictions): bool
    {
        if (str_ends_with($path, $restrictions)) {
            return false;
        }
        return true;
    }
}
