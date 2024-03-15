<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashasistController extends Controller
{
    public function index(){
        return view('admin.dashasist.index');
    }
}
