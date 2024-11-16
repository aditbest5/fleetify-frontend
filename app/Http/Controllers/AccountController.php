<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    //
    public function profile(){
        $id = Session::get('user_data')["id"];
        return view('pages.profile.account_setting', compact('id'));
    }

    public function change_password(){
        $id = Session::get('user_data')["id"];
        return view('pages.profile.change_password', compact('id'));
    }
}
