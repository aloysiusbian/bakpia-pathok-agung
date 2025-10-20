<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'admin'    => Admin::all()
        ];

        return view('pages.dashboard', $data);
    }
}
