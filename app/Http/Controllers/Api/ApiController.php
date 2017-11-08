<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\regRequest;

class ApiController extends Controller
{
    public function getReg(regRequest $request){
        $data['status']=true;
        $data['data']='yep';
        return response()->json($data);
    }
}
