<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        //数组内的，未登录用户访问
        $this->middleware('auth', [
            'except' => ['shwo','create','store','index']
        ]);

        //数组内的，登录用户 不能访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function index(User $user)
    {
        $users = $user::paginate(10);
        return view('users.index', compact('users'));
    }

    //个人中心
    public function show(User $user)
    {
        return view('users.show', compact('user'));
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
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);     //注册成功自动登陆
        session()->flash('success', '欢迎开启新的 Laravel 旅程');       //闪存session 可用 session->get('success');获取值
        return redirect()->route('users.show', [$user]);
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
}
