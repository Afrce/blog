<?php

namespace App\Http\Controllers\Api;

use App\Models\article;
use App\Models\comment;
use App\Models\type;
use function foo\func;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\regRequest;
use App\User;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getReg(regRequest $request)
    {
        $user = new User();
        $user->user = $request->input('user');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
        $user->tel = $request->input('tel');
        $user->save();
        $data['status'] = true;
        $data['data'] = 'yep';
        return response()->json($data);
    }

    //登录
    public function getLogin()
    {

        $payload = Request::only('user', 'password');

        try {
            $res = Auth::attempt($payload);
            if ($res == false) {
                $data['status'] = 402;
                $data['message'] = '账号密码错误，请确认无误后再试';
            } else {
                $data['status'] = 200;
                $user['user'] = Request::input('user');
                $user['token'] = JWTAuth::attempt($payload);
                $data['user'] = $user;
            }
        } catch (Exception $exception) {
            $data['status'] = 500;
            $data['message'] = "服务器内部问题请稍候再试";
        }
        return response()->json($data);
    }

    function getToken()
    {
        $all = type::all()->pluck('type','id');
        dd($all);
        $user = JWTAuth::parseToken()->getPayload()->get();
        dd($user);
    }

    //首页数据
    function getIndex()
    {
        $data = article::with('Type')->orderBy('created_at',"DESC")->paginate(15)->toArray();
        $returnData = [];
        foreach ($data['data'] as $item) {
            $one = [];
            $one['id'] = $item['id'];
            $one['title'] = $item['title'];
            $one['date'] = $item['created_at'];
            $one['type'] = $item['type']['type'];
            $returnData[] = $one;
        }
        return successRetun($returnData);
    }

    //文章详情
    function getArticle()
    {
        $id = Request::input('id');
        $art = article::query()->whereId($id)
            ->with(['Comment' => function ($query) {
                return $query->select('article_id', DB::raw('count(1) as t'))->groupBy('article_id');
            }])
            ->with(['Collection' => function ($query) {
                return $query->select('article_id', DB::raw('count(1) as ty'))->groupBy('article_id');
            }])
            ->get()
            ->toArray();
        if (count($art[0]['comment']) > 0) {
            $art[0]['comment'] = $art[0]['comment'][0]['t'];
        } else {
            $art[0]['comment'] = 0;
        }
        if (count($art[0]['collection']) > 0) {
            $art[0]['collection'] = $art[0]['collection'][0]['ty'];
        } else {
            $art[0]['collection'] = 0;
        }
        return response()->json($art[0]);
    }

    //评论
    function getComment()
    {
        $comment = comment::query()
            ->with(['user' => function ($query) {
                return $query->select('id', 'user');
            }])
            ->with('comment')
            ->orderBy('created_at','DESC')
            ->paginate(25)
            ->toArray();
        $data = $comment['data'];
        foreach ($data as &$item) {
            $item['userName'] = $item['user']['user'];
            unset($item['user']);
            if($item['comment']!=null){
                $id=$item['comment']['user_id'];
                $item['comment']['userName']=User::find($id)->user;
            }
        }
        return response()->json($data);
    }

    function getAddComment()
    {
        $comment = new comment();
        $userid = JWTAuth::parseToken()->getPayload()->get();
        $article_id = Request::input('articleId');
        if (Request::has('commentId')) {
            $commentId = Request::input('commentId');
        } else {
            $commentId = 0;
        }
        $comment->article = $article_id;
        $comment->user_id = $userid;
        $comment->comment_id = $commentId;
        $comment->comments = Request::input('comments');
        $result = $comment->save();
        return response()->json($result);
    }
}
