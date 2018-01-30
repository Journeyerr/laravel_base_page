@extends('layouts.default')

@section('title','个人中心')

@section('content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8">
                    <section class="user_info">
                        <a href="{{ route('users.show', $user->id) }}">
                            <img src="/image/longmao.png" alt="{{ $user->name }}" class="gravatar" style="margin: 0 auto;display: block;height: 100px;width: 100px;" />
                        </a>
                        <h1>{{ $user->name }}</h1>
                    </section>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if (Auth::check())
                @if ($user->id !== Auth::user()->id)
                    <div id="follow_form">
                        @if (Auth::user()->isFollowing($user->id))
                            <form action="{{ route('followers.destroy', $user->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm" style="margin: 0 auto;display: block;">取消关注</button>
                            </form>
                        @else
                            <form action="{{ route('followers.store', $user->id) }}" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-primary" style="margin: 0 auto;display: block;">关注</button>
                            </form>
                        @endif
                    </div>
                @endif
            @endif

            @if(count($statuses) > 0)
                @foreach($statuses as $status)
                    @include('statuses.list')
                @endforeach
            @endif

        </div>

    </div>
@endsection