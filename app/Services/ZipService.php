<?php

namespace App\Services;

use ZipArchive;

// author: Gemini 3.1 Pro
class ZipService
{
    /**
     * Read a file's content from a ZIP archive and determine its language.
     * For media files (image, video, audio), returns base64-encoded data instead.
     *
     * @param  string  $zipPath  The absolute path to the ZIP archive
     * @param  string  $filePath  The relative path of the file inside the ZIP
     * @return array{code: string|null, language: string, mediaType: string|null, mediaData: string|null}
     */
    public static function getFileContentAndLanguage(string $zipPath, string $filePath): array
    {
        $default = ['code' => null, 'language' => 'plaintext', 'mediaType' => null, 'mediaData' => null];

        if (!file_exists($zipPath)) {
            return $default;
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath) !== true) {
            return $default;
        }

        $content = $zip->getFromName($filePath);
        $zip->close();

        if ($content === false) {
            return $default;
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeType = self::getMediaMimeType($extension);

        if ($mimeType !== null) {
            return [
                'code' => null,
                'language' => 'plaintext',
                'mediaType' => $mimeType,
                'mediaData' => 'data:' . $mimeType . ';base64,' . base64_encode($content),
            ];
        }

        $language = self::determineLanguage($extension);

        return ['code' => $content, 'language' => $language, 'mediaType' => null, 'mediaData' => null];
    }

    /**
     * Return the MIME type if the extension is a supported media type, null otherwise.
     */
    public static function getMediaMimeType(string $extension): ?string
    {
        $map = [
            // Images
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'bmp' => 'image/bmp',

            // Video
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',

            // Audio
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
            'flac' => 'audio/flac',
            'aac' => 'audio/aac',
            'oga' => 'audio/ogg',

            // Document
            'pdf' => 'application/pdf',
        ];

        return $map[$extension] ?? null;
    }

    /**
     * Determine the language for Monaco editor based on file extension
     */
    public static function determineLanguage(string $extension): string
    {
        $map = [
            // Backend / général
            'php' => 'php',
            'py' => 'python',
            'java' => 'java',
            'cs' => 'csharp',
            'go' => 'go',
            'rb' => 'ruby',
            'rs' => 'rust',
            'swift' => 'swift',
            'kt' => 'kotlin',
            'sql' => 'sql',

            // C / C++
            'c' => 'c',
            'h' => 'c',
            'cpp' => 'cpp',
            'hpp' => 'cpp',

            // Web classique
            'html' => 'html',
            'css' => 'css',
            'scss' => 'scss',
            'sass' => 'scss',
            'less' => 'less',

            // JavaScript / TypeScript
            'js' => 'javascript',
            'mjs' => 'javascript',
            'cjs' => 'javascript',
            'ts' => 'typescript',

            // ⚡ Frontend moderne
            'jsx' => 'javascript',     // React JSX
            'tsx' => 'typescript',     // React TSX
            'vue' => 'html',           // Vue SFC (approximation)
            'svelte' => 'html',        // Svelte (approximation)

            // Données / config
            'json' => 'json',
            'xml' => 'xml',
            'yaml' => 'yaml',
            'yml' => 'yaml',
            'toml' => 'ini',
            'ini' => 'ini',
            'env' => 'shell',

            // Docs / script
            'md' => 'markdown',
            'sh' => 'shell',
            'bash' => 'shell',
            'zsh' => 'shell',
        ];

        return $map[strtolower($extension)] ?? 'plaintext';
    }

    /**
     * Get the file structure of a ZIP archive as a nested array.
     */
    public static function getStructure(string $zipPath): array
    {
        if (!file_exists($zipPath)) {
            return [];
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath) !== true) {
            return [];
        }

        $structure = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            if ($stat === false || !isset($stat['name'])) {
                continue;
            }

            $path = $stat['name'];

            // 🔒 Sécurité basique (évite les chemins dangereux)
            if (str_contains($path, '..')) {
                continue;
            }

            $isDirectory = str_ends_with($path, '/');

            $parts = explode('/', trim($path, '/'));
            $current = &$structure;

            $lastIndex = count($parts) - 1;

            foreach ($parts as $index => $part) {
                if ($part === '') {
                    continue;
                }

                // 📄 Fichier
                if ($index === $lastIndex && !$isDirectory) {
                    $current[$part] = $path;
                }
                // 📁 Dossier
                else {
                    if (!isset($current[$part]) || !is_array($current[$part])) {
                        $current[$part] = [];
                    }

                    $current = &$current[$part];
                }
            }

            // ⚠️ IMPORTANT: casser la référence
            unset($current);
        }

        $zip->close();

        return self::sortStructure($structure);
    }

    /**
     * Sort the structure: directories first, then files alphabetically.
     */
    private static function sortStructure(array $structure): array
    {
        $dirs = [];
        $files = [];

        foreach ($structure as $key => $value) {
            if (is_array($value)) {
                $dirs[$key] = self::sortStructure($value);
            } else {
                $files[$key] = $value;
            }
        }

        uksort($dirs, 'strnatcasecmp');
        uksort($files, 'strnatcasecmp');

        return array_merge($dirs, $files);
    }
}
