<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\regRequest;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller
{
    public function getReg(regRequest $request){
        $user=new User();
        $user->user=$request->input('user');
        $user->password=bcrypt($request->input('password'));
        $user->email=$request->input('email');
        $user->tel=$request->input('tel');
        $user->save();
        $data['status']=true;
        $data['data']='yep';
        return response()->json($data);
    }
    //登录
    public function postLogin(){

        $payload = Request::only('user', 'password');

        try {
            if (! $token = JWTAuth::attempt($payload)) {
                $data=['error' => 'token已经失效'];
            } else {
                $data=['token' => $token];
            }
        } catch (JWTException $e) {
            $data=['error' => '不能创建token'];
        }

        return response()->json($data);
    }
}
