@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <div class="flex">
                            <strong>
                            <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name}}</a> posted about {{ $thread->title }}
                            </strong>
                        </div>
                        @can ('update', $thread)
                         <div>
                            <form method="POST" action="{{ $thread->path() }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">Delete</button>
                            </form>
                        </div>
                        @endcan
                    </div>
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
                    has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
