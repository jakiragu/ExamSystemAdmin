<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamCatalog;



class DashboardController extends Controller
{
  public function index()
{
    $catalogs = ExamCatalog::all();
    $selectedExamId = null; // or set a default if needed

    return view('adminDashboard', compact('catalogs', 'selectedExamId'));
}
}