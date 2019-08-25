<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class PagesController extends Controller
{
    //
    public function root()
    {
    	return view('pages.root');
    }

    public function emailVerifyNotice(){
        return view('pages.email_verify_notice');
    }
}
