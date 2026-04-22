<?php

namespace App\Interface;

interface IProject
{
    /**
     * @return IFile[]
     */
    public function getFiles(): array;
    public function getRawContent(): string;
    public function setRawContent(string $rawContent): void;
    public function setFingerprint(array $fingerprint): void;
}
