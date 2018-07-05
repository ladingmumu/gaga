<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct(){
        //过滤未登录操作
        $this->middleware('auth', [
            'except' => ['show','create','store','index']
        ]);

        //只允许未登录用户访问
        $this->middleware('guest',[
            'only' => ['create']
        ]);

    }

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

    //显示编辑用户页面
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    //用户编辑
    public function update(User $user, Request $request){
        $this->validate($request, [
                'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        session()->flash('success','个人信息更新成功');
        return redirect()->route('users.show', $user->id);

    }

    //显示所有用户
    public function index(){
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    //删除用户
    public function destroy(User $user){
        $this->authorize('destroy', $user);

        $user->delete();
        session()->flash('success','成功删除');
        return redirect()->back();
    }
}
