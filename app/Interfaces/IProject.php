<?php

namespace App\Interface;

use App\Models\Fingerprint;

interface IProject
{
    public function getAbsolutePath(): string;

    public function getRawContent(): string;

    public function setRawContent(string $rawContent): void;

    /**
     * @return Fingerprint[]
     */
    public function getFingerprint(): array;

    /**
     * @param  Fingerprint[]  $fingerprint
     */
    public function setFingerprint(array $fingerprint): void;
}
