<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;
use Illuminate\View\View;

class Student extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.student', [
            'nav' => [
                ['label' => 'dashboard', 'url' => '/student/dashboard', 'icon' => 'layout-dashboard'],
                ['label' => 'profile', 'url' => '/student/profile', 'icon' => 'user'],
            ],
        ]);
    }
}
