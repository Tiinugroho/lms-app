<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Nanti Anda bisa menambahkan query seperti $totalTeachers = Teacher::count(); di sini
        return view('admin.dashboard'); 
    }
}