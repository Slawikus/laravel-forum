@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                    <a href="#">{{ $thread->creator->name}}</a> posted about {{ $thread->title }}
                    </strong>
                </div>

                <div class="panel-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach( $thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>
</div>
@endsection
