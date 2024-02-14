<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch the latest packages ordered by the created_at column
        $latestPackages = Package::latest()->take(8)->get();

        // Pass the latest packages to the view
        return view('home.index', compact('latestPackages'));
    }
}
