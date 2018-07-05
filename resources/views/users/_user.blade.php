 <li>
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar" />
    <a href="{{ route('users.show', $user->id) }}" class="username">{{ $user->name }}</a>

    @can ('destroy',$user)
        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-danger btn-sm delete-btn pull-right">
                删除
            </button>
        </form>
    @endcan
</li>