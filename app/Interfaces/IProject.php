<?php

namespace App\Interface;

interface IProject
{
    /**
     * @return IFile[]
     */
    public function getPathname(): string;
    public function getRawContent(): string;
    public function setRawContent(string $rawContent): void;
    public function setFingerprint(array $fingerprint): void;
}
