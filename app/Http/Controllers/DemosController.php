<?php

namespace App\Http\Controllers;

class DemosController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.demos.index');
    }
}
