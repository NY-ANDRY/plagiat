<?php

namespace App\Services\Cleaning;

class CleanPHPService
{
    private array $comments = [
        ['begin' => '//', 'end' => "\n"],
        ['begin' => '#', 'end' => "\n"],
        ['begin' => '/*', 'end' => '*/'],
    ];

    private string $varName = 'var';

    public function __construct()
    {
    }

    public function clean($text): string
    {
        $text = str_replace("\r\n", "\n", $text);
        $text = $this->rmCommentMulti($text);
        $text = $this->renameVars($text);
        $text = strtolower($text);
        $text = preg_replace('/\s+/', '', $text);

        return $text;
    }

    public function renameVars($text): string
    {
        $pos = strpos($text, '$');

        while ($pos !== false) {

            $endPos = $this->varEnd($text, $pos);

            $length = $endPos - ($pos + 1);

            $text = substr_replace($text, $this->varName, $pos + 1, $length);

            $pos = strpos($text, '$', $pos + strlen($this->varName) + 1);
        }

        return $text;
    }

    private function varEnd(string $text, int $pos): int
    {
        $len = \strlen($text);
        $i = $pos + 1;

        while ($i < $len) {
            $char = $text[$i];

            if (ctype_alnum($char) || $char === '_') {
                $i++;
            } else {
                break;
            }
        }

        return $i;
    }

    // // \s matches any whitespace character (spaces, tabs, newlines, etc.)
    // public function isWhitespace(string $str): bool
    // {
    //     return preg_match('/^\s*$/', $str) === 1;
    // }

    public function renameVarsRegex($text): string
    {
        $pattern = '/\$[a-zA-Z_][a-zA-Z0-9_]*/';
        $replacement = '$' . $this->varName;

        return preg_replace($pattern, $replacement, $text);
    }

    private function rmCommentMulti($text)
    {
        foreach ($this->comments as $comment) {
            $text = $this->rmComment($text, $comment['begin'], $comment['end']);
        }

        return $text;
    }

    private function rmComment($text, $commentBegin, $commentEnd)
    {
        $posBEGIN = strpos($text, $commentBegin);

        while ($posBEGIN !== false) {
            $posEND = strpos($text, $commentEnd, $posBEGIN);

            if ($posEND === false) {
                $l = \strlen($text) - $posBEGIN;
                $text = substr_replace($text, '', $posBEGIN, $l);
                break;
            }

            $posEND += \strlen($commentEnd);
            $l = $posEND - $posBEGIN;

            $text = substr_replace($text, '', $posBEGIN, $l);

            $posBEGIN = strpos($text, $commentBegin);
        }

        return $text;
    }

    private function rmCommentRegex($text, $commentBegin, $commentEnd)
    {
        $begin = preg_quote($commentBegin, '/');
        $end = preg_quote($commentEnd, '/');

        return preg_replace("/$begin.*?$end/s", '', $text);
    }
}
