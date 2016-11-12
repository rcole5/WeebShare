@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="edit-heading">Edit Image | </h3><h4 id="delete" class="edit-heading">Delete Image</h4></div>
                    <div class="panel-body">
                        <!-- Edit Title -->
                        {!! Form::open(array('id' => 'edit-title')) !!}
                        <p id="title-success" class="success">
                            @if(Session::has('title_success'))
                                {!! Session::get('title_success') !!}
                            @endif
                        </p>
                        <p id="title-error" class="errors">
                            @if(Session::has('title_error'))
                                {!! Session::get('title_error') !!}
                            @endif
                        </p>
                            <label for="title">Title: </label>
                            {!! Form::text('title', $picture->picture_title, ['class' => 'form-control-static edit-text']) !!}
                            {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
                        {!! Form::close() !!}

                        <!-- Display Image -->
                        <img class='image edit-image' src="{{ $picture->picture_location . $picture->picture_name . '.' . $picture->picture_extension }}">

                        <!-- Edit Description -->
                        {!! Form::open(array('id' => 'edit-description')) !!}
                        <p id="description-success" class="success">
                            @if(Session::has('description_success'))
                               {!! Session::get('description_success') !!}
                            @endif
                        </p>
                        <p id="description-error" class="errors">
                            @if(Session::has('description_error'))
                                {!! Session::get('description_error') !!}
                            @endif
                        </p>
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
