@extends('layouts.default')

@section('title','主页')

@section('content')

    @if(Auth::check())

        <div class="row">
            <div class="col-md-8">
                <section class="status_form">
                    {{--发布表单--}}
                    <form action="{{ route('statuses.store') }}" method="POST">
                        @include('shared.errors')
                        {{ csrf_field() }}
                        <textarea class="form-control" rows="3" placeholder="聊聊新鲜事儿..." name="contents">{{ old('contents') }}</textarea>
                        <br>
                        <button type="submit" class="btn btn-primary pull-right">发布</button>
                    </form>
                    {{--发布表单 end--}}
                </section>
                <h3>微博列表</h3>
                <hr>
                @if (count($feed))
                    <ol class="statuses">
                        @foreach ($feed as $status)
                            @include('statuses.list', ['user' => $status->user])
                        @endforeach
                        {!! $feed->render() !!}
                    </ol>
                @endif
            </div>

            <aside class="col-md-4">
                {{--用户信息--}}
                <section class="user_info">
                    @include('shared.user_info', ['user' => Auth::user()])
                </section>
                {{--用户信息end--}}

                {{--粉丝关系统计--}}
                <section class="stats" style="margin-left: 28%;">
                    <div class="stats">
                        <a href="{{ route('users.followings', $user->id) }}">
                            <strong id="following" class="stat">
                                {{ count($user->followerings) }}
                            </strong>
                            关注
                        </a>
                        <a href="{{ route('users.followers', $user->id) }}">
                            <strong id="followers" class="stat">
                                {{ count($user->followers) }}
                            </strong>
                            粉丝
                        </a>
                        <a href="{{ route('users.show', $user->id) }}">
                            <strong id="statuses" class="stat">
                                {{ $user->statuses()->count() }}
                            </strong>
                            微博
                        </a>
                    </div>
                </section>
                {{--粉丝关系统计end--}}
            </aside>
        </div>


    @else
        <div class="jumbotron">
            <h1>ZAHANG AN YUAN </h1>
            <p class="lead">
                看到的是我 <a href="http://www.echophp.top"> Laravel </a>   的学习之路。
            </p>
            <p>
                一切，将从这里开始。
            </p>
                <p>
                    <a class="btn btn-lg btn-success" href="{{ route('users.create') }}" role="button">现在注册</a>
                </p>
        </div>
    @endif
@endsection