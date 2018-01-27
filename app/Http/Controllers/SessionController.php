<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //用户登陆界面
    public function create()
    {
       return view('session.create');
    }

    //用户登陆界面
    public function store(Request $request)
    {
        $createDetail = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);
        
        if(Auth::attempt($createDetail,$request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success', '欢迎回来！');
                return redirect()->intended(route('users.show', [Auth::user()]));
            } else {
                Auth::logout();
                session()->flash('warning', '您的账号未激活，请检查邮箱激活邮件！');
                return redirect('/');
            }

        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
        
        return ;
    }

    //注销登录
    public function destore()
    {
        Auth::logout();
        session()->flash('success', '注销成功！');
        return redirect('login');
    }

}
