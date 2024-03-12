<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        return view('admin.hospital.index');
    }
    public function healthReport()
    {
        return view('admin.hospital.health_report');
    }
}
