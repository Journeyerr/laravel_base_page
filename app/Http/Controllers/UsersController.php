<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        //数组内的，未登录用户访问
        $this->middleware('auth', [
            'except' => [ 'show', 'create', 'store', 'index', 'checkConfirEmail' ]
        ]);

        //数组内的，登录用户 不能访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //用户列表
    public function index(User $user)
    {
        $users = $user::paginate(10);
        return view('users.index', compact('users'));
    }

    //个人中心
    public function show(User $user)
    {
        $statuses = $user->statuses()->orderBy('id','desc')->paginate(10);

        return view('users.show', compact('user', 'statuses'));
    }

    //注册页面
    public function create()
    {
        return view('users.create');
    }

    //注册请求
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50|min:2',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => uniqid()
        ]);

        $this->sendConfirEmail($user);
//        Auth::login($user);     //注册成功自动登陆
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');       //闪存session 可用 session->get('success');获取值
        return redirect('/');
    }

    //用户编辑页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);      // 加载授权类里的 update 授权方法 app/Policies/UserPolicy.php
        return view('users.edit', compact('user'));

    }

    //用户编辑请求
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50|min:2',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);      // 加载授权类里的 update 授权方法 app/Policies/UserPolicy.php

        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($this->password);
        }

        $user->update($data);

        return redirect()->route('users.show', [$user]);
    }

    //用户删除
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);

        $user->delete();
        session()->flash('success', $user->name . ' 删除成功');

        return back();
    }

    //发送邮件
    private function sendConfirEmail($user)
    {
        $view = 'email.confirm';
        $data = compact('user');
        $from = 'totoross@qq.com';
        $name = 'totoross';
        $to = $user->email;
        $subject = '感谢注册 Laravel ，请确认你的邮箱。';

        Mail::send($view, $data, function($msg) use ($from, $name, $to, $subject){
            $msg->from($from, $name)->to($to)->subject($subject);
        });
    }

    //确认激活邮件
    public function checkConfirEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，账号已激活');
        return redirect()->route('users.show', [$user]);
    }

    //用户关注
    public function followings(User $user)
    {
        $users = $user->followerings()->paginate(20);
        $title = '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    //用户粉丝
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(20);
        $title = '粉丝列表';
        return view('users.show_follow', compact('users', 'title'));
    }
}
