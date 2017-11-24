<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    function  index(){
        return view('welcome');
    }
}
