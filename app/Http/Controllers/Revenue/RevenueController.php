<?php

namespace App\Http\Controllers\Revenue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        return view('admin.revenue.index');
    }
}
