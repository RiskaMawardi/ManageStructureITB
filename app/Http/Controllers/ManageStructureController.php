<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageStructureController extends Controller
{
    public function index(){
        return view('Manage.index');
    }
}
