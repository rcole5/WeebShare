@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Side Bar -->
        <div class="col-md-2 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading"><h3>Menu</h3></div>
                <div class="panel-body">
                    <!-- Search Bar -->
                    <h4>Search: </h4>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                    <br>
                    <!-- Tags -->

                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <div class="panel panel-default">

                <div class="panel-heading"><h1 class="heading">Gallery</h1></div>
                <div class="panel-body">
                    <div class="index-gallery">
                        @foreach ($pictures as $p)
                            <div class="thumbnail gallery-item">
                                <a href="/image/{{ $p->picture_id }}">
                                    <div class="picture-container">
                                        <img src="{{
                                    $p->picture_location . '/' . $p->picture_name . '.' . $p->picture_extension
                                }}">
                                    </div>
                                </a>
                                <div class="caption">
                                    <a href="image?p={{ $p->picture_id }}">
                                        <h4>{{ $p->picture_title }}</h4>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br>

            </div>
        </div>
    </div>
@endsection
