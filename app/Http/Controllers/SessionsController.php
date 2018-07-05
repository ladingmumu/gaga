<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct(){
        //只允许未登录用户访问
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }



    //显示登录页面
    public function create(){
        return view('sessions.create');
    }

    //登录
    public function store(Request $request){
        $data = $this->validate($request, [
               'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($data, $request->has('remember'))) {
            //身份验证通过
            session()->flash('success','登录成功，欢迎回来');
            return redirect()->intended(route('users.show',[Auth::user()]));
        } else{
            //身份验证失败
            session()->flash('danger','邮箱和密码不匹配');
            return redirect()->back();
        }
        return;
    }

    //退出登录
    public function destroy(){
        Auth::logout();
        session()->flash('success','您已经退出登录');
        return redirect()->route('login');
    }

}
