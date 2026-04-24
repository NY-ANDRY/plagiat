<?php

namespace App\Services;

use App\Models\Fingerprint;

class FingerprintService
{
    /**
     * @param string $text
     * @param int $k
     * @return string[]
     */
    public function separate(string $text, int $k): array
    {
        $result = [];
        $length = \strlen($text);

        if ($k <= 0 || $k > $length) {
            return [];
        }

        for ($i = 0; $i <= $length - $k; $i++) {
            $result[] = substr($text, $i, $k);
        }

        return $result;
    }

    /**
     * if $text string -> hash the strng
     * if $test string[] -> hash each string
     * 
     * @param string|string[] $text
     * @throws \Exception
     * @return string|string[]
     */
    public function hash(string|array $text): string|array
    {
        if (\is_string($text)) {
            return md5($text);
        }

        $result = [];
        foreach ($text as $value) {
            if (!\is_string($value)) {
                throw new \Exception("only string or array of string accepted");
            }
            $result[] = md5($value);
        }

        return $result;
    }

    /**
     * @param string[] $hash
     * @param int $w
     * @return Fingerprint[]
     */
    public function reduce(array $hash, int $w): array
    {
        $result = [];
        $length = \count($hash);

        if ($w <= 0 || $length < $w) {
            return [];
        }

        $parts = \array_slice($hash, 0, $w);
        $min = min($parts);

        $result[] = new Fingerprint([
            'hash_value' => $min,
            'position' => 0,
        ]);

        for ($i = 1; $i <= $length - $w; $i++) {

            $parts = \array_slice($hash, $i, $w);
            $curMin = min($parts);

            if ($min === $curMin) {
                continue;
            }

            $min = $curMin;
            $result[] = new Fingerprint([
                'hash_value' => $min,
                'position' => $i,
            ]);

        }

        return $result;
    }

}
