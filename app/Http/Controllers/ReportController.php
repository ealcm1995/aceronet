<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales()
    {
        return view('reports.sales');
    }

    public function inventory()
    {
        return view('reports.inventory');
    }
}
