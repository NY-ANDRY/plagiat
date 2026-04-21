<?php

namespace App\View\Components\Icon;

use App\Models\FileExtension as FileExtensionModel;
use Illuminate\View\Component;

class FileExtension extends Component
{
    public FileExtensionModel $extension;

    public function __construct(FileExtensionModel $extension)
    {
        $this->extension = $extension;
    }

    public function render()
    {
        return view('components.icon.file-extension');
    }
}
