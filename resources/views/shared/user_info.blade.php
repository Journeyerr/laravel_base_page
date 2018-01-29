<a href="{{ route('users.show', $user->id) }}">
    <img src="{{ $user->gravatar('100') }}" alt="{{ $user->name }}" class="gravatar" style="margin: 0 auto;display: block"/>
</a>
<h1>{{ $user->name }}</h1>