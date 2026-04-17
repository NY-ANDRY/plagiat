<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfController extends Controller
{
    public function dashboard(): View
    {
        return view('prof.dashboard');
    }

    public function exam(): View
    {
        return view('prof.exam');
    }
}
