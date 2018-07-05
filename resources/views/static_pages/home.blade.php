@extends('layouts.default')
@section('title','home')
@section('content')
<div class="jumbotron">
    <h1>Hello GaGa</h1>
    <p class="lead">
        欢迎来到我的魔法王国
    </p>
    <p>
        一起，将从这里开始
    </p>
    <p>
        <a href="{{ route('signup') }}" class="btn btn-lg btn-success" role="button">现在注册</a>
    </p>
</div>
@stop