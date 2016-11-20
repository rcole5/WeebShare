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
                    <form class="sidebar-search" action="/search" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q">
                            <span class="input-group-btn">
                                <input class="btn btn-default" type="submit" value="Go!">
                            </span>
                        </div>
                    </form>

                    <!-- Tags -->
                    <div class="tags">
                        <h4>Tags on This Page</h4>
                        <ul class="tags">
                            @foreach ($tags as $tag)
                                <a href="/search?q={{ $tag }}"><li class="sidebar-tag">{{ $tag }}</li></a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <div class="panel panel-default">

                <div class="panel-heading"><h1 class="heading">Gallery</h1></div>
                <div class="panel-body">
                    @if(Session::has('notify'))
                        <p class="error">{{ Session::get('notify') }}</p>
                    @endif
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
                                <a href="image/{{ $p->picture_id }}">
                                    <h4>{{ $p->picture_title }}</h4>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <br>
                    <div class="btn-toolbar" role="toolbar" aria-label="page-number-group">
                        <div class="btn-group" role="group" aria-label="pages">
                            <!-- Previous Page Button -->
                            @if($current <= 1)
                                <a class="btn btn-default disabled">&larr;</a>
                            @else
                                <a href="/page/{{ $current - 1 }}" class="btn btn-default">&larr;</a>
                            @endif

                            <!-- Page Number Buttons -->
                            @for($i = 1; $i <= $pages; $i++)
                                @if($i == $current)
                                    <a href="/page/{{ $i }}" class="btn btn-default active">{{ $i }}</a>
                                @else
                                    <a href="/page/{{ $i }}" class="btn btn-default">{{ $i }}</a>
                                @endif
                            @endfor

                            <!-- Next Page Button -->
                            @if($current >= $pages)
                                <a class="btn btn-default disabled">&rarr;</a>
                            @else
                                <a href="/page/{{ $current + 1 }}" class="btn btn-default">&rarr;</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
