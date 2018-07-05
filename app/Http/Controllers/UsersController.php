<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //显示注册页面
    public function create(){
        return view('users.create');
    }

    //显示个人信息的页面
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //注册
    public function store(Request $request){
        $this->validate($request, [
                'name' => 'required|max:50',
               'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
                'name' => $request->name,
               'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','注册成功');
        return redirect()->route('users.show',compact('user'));
    }

}
