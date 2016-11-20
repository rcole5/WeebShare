@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Side Bar -->
        <div class="col-md-2 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading"><h3>Tags</h3></div>
                <div class="panel-body">
                    <ul class="tags">
                        @foreach ($tags as $tag)
                            <a href="/search?q={{ $tag->tag_name }}"><li class="sidebar-tag">{{ $tag->tag_name }}</li></a>
                        @endforeach
                    </ul>
                    <br>
                    <h4>Description: </h4>
                    <p>{{ $description }}</p>
                    <br>
                    <h4>Uploaded by: <a href="/user/{{ $user->id }}">{{ $username }}</a> ({{ $upload_count }})</h4>
                    <h5>On: {{ $upload_date  }}</h5>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <div class="panel panel-default">

            <div class="panel-heading">
                <h1 class="heading">
                    {{ $title }}
                    @if(Auth::id() == $picture->user_id)
                        | <a href="/image/{{ $picture->picture_id }}/edit">edit</a>
                    @endif
                </h1>
            </div>
            <div class="panel-body">
                @if (Session::has('user_error'))
                    <p class="errors">{!! Session::get('user_error') !!}</p>
                @endif
                <img class='image' src="{{ $url }}">
            </div>

            <!-- Comments -->
            <div class="panel-heading"><h2>Comments</h2></div>
            <div class="panel-body">

                @if (Auth::check())
                    {!! Form::open(array('url' => 'image/comment', 'method' => 'POST')) !!}
                    <div class="control-group">
                        <div class="controls">
                            <!-- Add New Comment -->
                            <label for="comment">Comment: </label>
                            {!! Form::textArea('comment', null, ['class' => 'form-control comment-text', 'size' => '65x3']) !!}
                            @if(Session::has('comment_error'))
                                <p class="errors">{!! Session::get('comment_error') !!}</p>
                            @endif

                            {!! Form::hidden('pid', Crypt::encrypt($pid)) !!}
                        </div>
                    </div>
                    <br>
                    {!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}
                    {!! Form::close() !!}
                @else
                    <p>Please <a href="/login">login</a> to comment.</p>
                @endif

                <br>

                <!-- Display Comments -->
                @foreach ($comments as $comment)
                    <span class="comment">{{ $comment->name }} ({{ $comment->comment_count }}) on {{ $comment->comment_date }}</span>
                    <p class="comment">{{ $comment->comment_text }}</p>
                @endforeach

            </div>
                </div>
        </div>
    </div>
@endsection
