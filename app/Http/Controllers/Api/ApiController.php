<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\regRequest;
use App\User;
use Mockery\Exception;
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
    public function getLogin(){

        $payload = Request::only('user', 'password');

        try{
            $res=Auth::attempt($payload);
            if($res==false){
                $data['status']=402;
                $data['message']='账号密码错误，请确认无误后再试';
            }else{
                $data['status']=200;
                $user['user']=Request::input('user');
                $user['token']=JWTAuth::attempt($payload);
                $data['user']=$user;
            }
        }catch (Exception $exception){
            $data['status']=500;
            $data['message']="服务器内部问题请稍候再试";
        }
        return response()->json($data);
    }
}
