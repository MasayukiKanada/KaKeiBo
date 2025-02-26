<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
// use App\Models\Partner;
// use App\Models\Subject;
// use App\Models\PrimaryCategory;
// use App\Models\SecondaryCategory;
// use App\Models\ThirdryCategory;

class ChartController extends Controller
{
    public function table()
    {
        return Inertia::render('Chart/Table');
    }
}
