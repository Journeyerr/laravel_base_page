<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
{
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
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
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
