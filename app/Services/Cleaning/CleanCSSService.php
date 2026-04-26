<?php

namespace App\Services\Cleaning;

class CleanCSSService
{
    private array $comments = [
        ['begin' => '/*', 'end' => '*/'],
    ];

    public function __construct()
    {
    }

    public function clean($text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/\s+/', '', $text);
        $text = $this->rmCommentMulti($text);

        return $text;
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
