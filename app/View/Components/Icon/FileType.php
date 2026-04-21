<?php

namespace App\View\Components\Icon;

use App\Models\FileType as FileTypeModel;
use Illuminate\View\Component;

class FileType extends Component
{
    public FileTypeModel $fileType;

    public function __construct(FileTypeModel $fileType)
    {
        $this->fileType = $fileType;
    }

    public function render()
    {
        return view('components.icon.file-type');
    }
}
