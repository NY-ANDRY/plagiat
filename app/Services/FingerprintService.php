<?php

namespace App\Services;

use App\Models\Fingerprint;

class FingerprintService
{
    /**
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
     * @param  string|string[]  $text
     * @return string|string[]
     *
     * @throws \Exception
     */
    public function hash(string|array $text): string|array
    {
        if (\is_string($text)) {
            return hexdec(substr(md5($text), 0, 8));
            // return crc32($text);
        }

        $result = [];
        foreach ($text as $value) {
            if (!\is_string($value)) {
                throw new \Exception('only string or array of string accepted');
            }
            $result[] = hexdec(substr(md5($value), 0, 8));
            // $result[] = crc32($value);
        }

        return $result;
    }

    /**
     * @param  string[]  $hash
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

    // ////////

    public function h1($string, $m)
    {
        $hash = 0;
        $length = \strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $hash = (($hash << 5) - $hash + \ord($string[$i])) % $m;
        }

        return $hash < 0 ? $hash + $m : $hash;
    }

    public function h2($string, $m)
    {
        $hash = 5381;
        $length = \strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $hash = ((($hash << 5) + $hash) ^ \ord($string[$i])) % $m;
        }

        return $hash < 0 ? $hash + $m : $hash;
    }

    public function getIndex($element, $arraySize, $hashCount)
    {
        $hash1 = $this->h1($element, $arraySize);
        $hash2 = $this->h2($element, $arraySize);
        $result = [];

        for ($i = 0; $i < $hashCount; $i++) {
            $index = ($hash1 + $i * $hash2) % $arraySize;
            $result[] = abs($index);
        }

        return $result;
    }
}
