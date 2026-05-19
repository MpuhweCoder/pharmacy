<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class PharmacistController extends Controller
{
    /** Pharmacist dashboard */
    public function dashboard()
    {
        return view('pharmacist.dashboard');
    }
}