<li id="status-{{ $status->id }}">
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