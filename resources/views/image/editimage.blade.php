@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="edit-heading">Edit Image | </h3><h4 id="delete" class="edit-heading">Delete Image</h4></div>
                    <div class="panel-body">
                        <!-- Edit Title -->
                        {!! Form::open(array('url' => '/image/' . $pid . '/edit/title')) !!}
                            @if(Session::has('title_success'))
                                <p class="success">{!! Session::get('title_success') !!}</p>
                            @endif
                            @if(Session::has('title_error'))
                                <p class="errors">{!! Session::get('title_error') !!}</p>
                            @endif
                            <label for="title">Title: </label>
                            {!! Form::text('title', $picture->picture_title, ['class' => 'form-control-static edit-text']) !!}
                            {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
                        {!! Form::close() !!}

                        <!-- Display Image -->
                        <img class='image edit-image' src="{{ $picture->picture_location . $picture->picture_name . '.' . $picture->picture_extension }}">

                        <!-- Edit Description -->
                        {!! Form::open(array('url' => '/image/' . $pid . '/edit/description')) !!}
                            @if(Session::has('description_success'))
                                <p class="success">{!! Session::get('description_success') !!}</p>
                            @endif
                            @if(Session::has('description_error'))
                                <p class="errors">{!! Session::get('description_error') !!}</p>
                            @endif
                            <label for="title">Description: </label>
                            <br>
                            {!! Form::textArea('description', $picture->picture_description, ['size'=>'65x3', 'class'=>'form-control-static']) !!}
                            <br>
                            {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
                        {!! Form::close() !!}

                        <!-- Edit Tags -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
