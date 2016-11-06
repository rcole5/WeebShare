@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Upload</h2></div>
                    <div class="panel-body">

                        <div class="form-group{{ $errors->has('') ? ' has-error' : '' }}">
                            {!! Form::open(array('url'=>'upload/upload','method'=>'POST', 'files'=>true)) !!}
                            <div class="control-group">
                                <div class="controls">
                                    <!-- Image Title Input -->
                                    <label for="title">Title: </label>
                                    {!! Form::text('title', null, ['class'=>'form-control']) !!}
                                    @if(Session::has('title_error'))
                                        <p class="errors">{!! Session::get('title_error') !!}</p>
                                    @endif
                                    <br>

                                    <!-- Image Input -->
                                    <label for="image">Image (jpeg, jpg, png, gif): </label>
                                    {!! Form::file('image', array('class'=>'btn btn-default btn-file')) !!}
                                    @if(Session::has('image_error'))
                                        <p class="errors">{!! Session::get('image_error') !!}</p>
                                    @endif
                                    <br>

                                    <!-- Image Description Input -->
                                    <label for="description">Description: </label>
                                    {!! Form::textArea('description', null, ['size'=>'65x3', 'class'=>'form-control']) !!}
                                    @if(Session::has('description_error'))
                                        <p class="errors">{!! Session::get('description_error') !!}</p>
                                    @endif
                                    <br>

                                    <!-- Image Tags Input -->
                                    <label for="tags">Tags (separate by ,): </label>
                                    {!! Form::text('tags', null, ['class'=>'form-control']) !!}
                                    @if(Session::has('tags_error'))
                                        <p class="errors">{!! Session::get('tags_error') !!}</p>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div id="success">
                                {!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}
                                {!! Form::close() !!}
                            </div>
                            @if(Session::has('log'))
                                <p class="errors">{!! Session::get('log') !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
