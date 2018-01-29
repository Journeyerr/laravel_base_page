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
            @if(count($statuses) > 0)
                @foreach($statuses as $status)
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
                    <br>
                @endforeach
            @endif

        </div>

    </div>
@endsection