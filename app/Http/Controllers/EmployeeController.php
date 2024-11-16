<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(){
        return view('pages.employee.index');
    }
    public function create(){
        return view('pages.employee.create');
    }

    public function edit($id){
        return view('pages.employee.update', compact('id'));
    }
}
