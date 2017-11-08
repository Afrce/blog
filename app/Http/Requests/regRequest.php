<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class regRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user'=>array('unique:users','required'),
            'password'=>array('required'),
            'tel'=>array('required'),
            'email'=>array('unique:users','required')
        ];
    }
    public function messages(){
        return [
            'user.unique'=>'该用户名已被注册',
            'user.required'=>'必须填写用户名',
            'password.required'=>'必须填写密码',
            'tel.required'=>'必须填写用户名',
            'email.required'=>'必须填写邮箱',
            'email.unique'=>'该邮箱已被注册'
        ];
    }
}
