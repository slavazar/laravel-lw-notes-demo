<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }
    
}
