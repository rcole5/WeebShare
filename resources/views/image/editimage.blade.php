@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="edit-heading">Edit Image | </h3><h4 id="delete" class="edit-heading" data-toggle="modal" data-target="#confirm-delete">Delete Image</h4></div>
                    <!-- Delete Confirm Popup -->
                    <div id="confirm-delete" class="modal fade" role="alertdialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Image</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this image?</p>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::open(array('url' => '/image/' . $picture->picture_id . '/edit/delete')) !!}
                                        {!! Form::submit('Yes', array('class' => 'btn btn-primary')) !!}
                                        {!! Form::button('No', array('class' => 'btn btn-primary', 'data-dismiss' => 'modal')) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <label for="edit-description">Description: </label>
                            <br>
                            {!! Form::textArea('description', $picture->picture_description, ['size'=>'65x3', 'class'=>'form-control-static']) !!}
                            <br>
                            {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
                        {!! Form::close() !!}

                        <!-- Edit Tags -->
                        {!! Form::open(array('id' => 'edit-tags')) !!}
                            <label for="edit-tags">Edit tags (separate with ,):</label><br>
                            {!! Form::text('tags', null, ['class' => 'form-control-static edit-text', 'id' => 'add-tag']) !!}
                            {!! Form::submit('Add', array('class' => 'btn btn-primary')) !!}
                        {!! Form::close() !!}
                        <ul id="tag-list" class="tags">
                        @foreach($tags as $tag)
                            <li class="input-group tag-group">
                                <span class="tag">{{ $tag->tag_name }}</span>
                                <button class="btn btn-primary">X</button>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
