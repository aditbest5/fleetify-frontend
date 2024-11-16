<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AbsentController extends Controller
{
    //
    public function absent_in(){
        return view('pages.absent.absent_in');
    }

    public function absent_out(){
        return view('pages.absent.absent_out');
    }

    public function absent_list(){
        return view('pages.absent.absent_list');
    }

    public function history_absent(){
        $id = Session::get("user_data")["id"];
        return view('pages.absent.history_absent', compact('id'));
    }
}
