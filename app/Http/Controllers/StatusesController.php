<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    //执行动态创建请求
    public function store(Request $request)
    {
        $this->validate($request, [
            'contents' => 'required|max:140'
        ]);

        //Auth::user() 获取当前用户对象
        Auth::user()->statuses()->create([
            'content' => $request->contents
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();

    }

    //删除动态
    public function destroy()
    {

    }


}
