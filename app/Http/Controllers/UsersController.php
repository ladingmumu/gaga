<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{

    public function __construct(){
        //过滤未登录操作
        $this->middleware('auth', [
            'except' => ['show','create','store','index','confirmEmail']
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
        $statuses = $user->statuses()->orderBy('created_at','desc')->paginate(5);
        return view('users.show',compact('user','statuses'));
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
        // Auth::login($user);
        // session()->flash('success','注册成功');
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已经发送到您的注册邮箱上了，请注意查收。');
        return redirect()->route('home');
    }

    //发送邮件给指定的用户
    protected function sendEmailConfirmationTo($user){
            $view = 'emails.confirm';
            $data = compact('user');
              $to = $user->email;
         $subject = '感谢注册 GAGA 应用！请确认您的邮箱。';

         Mail::send($view, $data, function($message) use ($to, $subject){
            $message->to($to)->subject($subject);
         });
    }

    //用户的激活
    public function confirmEmail($token){
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activation_token = null;
        $user->activated = true;
        $user->save();
        Auth::login($user);
        session()->flash('success','恭喜你，激活成功');
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

    //显示用户的关注人列表
    public function followings(User $user){
        $users = $user->followings()->paginate(5);
        $title = '关注的人';
        return view('users.show_follow',compact('users','title'));
    }

    //显示粉丝列表
    public function followers(User $user){
        $users = $user->followers()->paginate(5);
        $title = '粉丝';
        return view('users.show_follow',compact('users','title'));
    }

}
