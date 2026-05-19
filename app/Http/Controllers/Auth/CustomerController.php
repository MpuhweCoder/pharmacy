<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /** Customer dashboard */
    public function dashboard()
    {
        $user = Auth::user();
        return view('customer.dashboard', compact('user'));
    }
}