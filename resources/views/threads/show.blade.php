@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name}}</a> posted about {{ $thread->title }}
                    </strong>
                </div>

                <div class="panel-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>

            @foreach( $replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if ( Auth::check() )
                <form method="POST" action="{{ $thread->path().'/replies' }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="body" class="form-control"
                        placeholder="Have something to say?" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>This thread was created {{ $thread->created_at->diffForHumans() }}
                    by <a href="#">{{ $thread->creator->name }}</a> and currently
                    has {{ $thread->repliesCount }} {{ str_plural('reply', $thread->repliesCount) }}.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
