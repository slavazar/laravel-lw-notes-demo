<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;

class NoteController extends Controller
{

    public function index()
    {
        sleep(1);
        return view('notes.index');
    }
}
