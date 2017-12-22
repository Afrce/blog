<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'content'=>'required',
            'title'=>'required',
            'type'=>'required'
        ];
    }
    public function messages()
    {
        return[
            'content.required'=>'文章不能为空',
            'title.required'=>'标题不能为空',
            'type.required'=>'必须选择文章类别',
        ];
    }
}
