<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Asset;
use App\Models\Unit;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_assets' => Asset::count(),
            'total_units' => Unit::count(),
            'total_value' => Asset::sum('nilai_perolehan'),
        ];

        return view('landing', compact('stats'));
    }
}
