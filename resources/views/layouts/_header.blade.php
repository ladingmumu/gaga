<header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            <a href="{{ route('home') }}" id="logo">GaGa</a>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li><a href="#">所有用户</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('users.show', Auth::user()->id) }}">个人中心</a></li>
                            <li><a href="#">资料更新</a></li>
                            <li class="divider"></li>
                            <li>
                                <a id="logout" href="{{ route('logout') }}">
                                    <form method="POST" action="{{ route('logout') }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-block" name="button">退出</button>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('help') }}">帮助</a></li>
                    <li><a href="{{ route('login') }}">登录</a></li>
                @endif
                </ul>
            </nav>
        </div>
    </div>
</header>