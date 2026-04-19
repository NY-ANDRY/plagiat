<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;
use Illuminate\View\View;

class Prof extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.prof', [
            'nav' => [
                ['label' => 'dashboard', 'url' => '/prof/dashboard', 'icon' => 'layout-dashboard'],
                ['label' => 'exams', 'url' => '/prof/exams', 'icon' => 'file-text'],
                ['label' => 'students', 'url' => '/prof/students', 'icon' => 'graduation-cap'],
            ],
        ]);
    }
}
