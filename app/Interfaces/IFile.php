<?php

namespace App\Interface;

interface IFile
{
    public function getContent(): string;
    public function getRawContent(): string;
    public function getExtension(): string;
}
