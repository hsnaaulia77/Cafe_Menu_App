<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function daily()
    {
        return view('reports.daily');
    }
} 