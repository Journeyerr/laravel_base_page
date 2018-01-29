<li id="status-{{ $status->id }}">
    {{--删除按钮--}}
    @can('destroy', $status)
        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger status-delete-btn" style="float: right">删除</button>
        </form>
    @endcan
    <a href="{{ route('users.show', $user->id )}}">
        <img src="/image/longmao.png" alt="{{ $user->name }}"  class="gravatar " style="display: inline-block;height: 35px;width: 35px;"/>
    </a>

    <span class="user">
        <a href="{{ route('users.show', $user->id )}}">{{ $user->name }}</a>
    </span>
    <span class="timestamp" style="display: block;margin-left: 60px;color:#999;">
        {{ $status->created_at->diffForHumans() }}
    </span>

    <span class="content" style="display: block;margin-left: 60px">
        {{ $status->content }}
    </span>

</li>
<hr>