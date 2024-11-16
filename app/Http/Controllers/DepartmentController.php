<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //
    public function index(){
        return view('pages.department.index');
    }

    public function create(){
        return view('pages.department.create');
    }

    public function edit($id){
        return view('pages.department.update', compact('id'));
    }
}
