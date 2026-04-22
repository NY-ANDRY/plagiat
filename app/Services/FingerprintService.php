<?php

namespace App\Services;

class FingerprintService
{
    public function separateAndHash(string $text, int $k): array
    {
        return [];
    }

    public function separate(string $text, int $k): array
    {
        return [];
    }

    public function hash(string|array $text): string|array
    {
        if (is_array($text)) {
            $result = [];
            foreach ($text as $value) {
                if (is_array($value)) {
                    throw new \Exception("only string or array of string accepted");
                }
                $result[] = md5($value);
            }
            return $result;
        }
        return md5($text);
    }
}
