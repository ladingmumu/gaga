<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //过滤必须登录的操作
    public function __construct(){
        $this->middleware('auth');
    }

    //创建微博
    public function store(Request $request){
        $this->validate($request, [
            'content' => 'max:140|required',
        ]);
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        return redirect()->back();

    }

    //删除微博
    public function destroy(Status $status){
        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success','微博已经成功删除');
        return redirect()->back();

    }
}
