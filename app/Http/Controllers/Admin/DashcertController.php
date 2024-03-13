<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashcertController extends Controller
{
    public function index(){
        return view('admin.dashcert.index');
    }
}
