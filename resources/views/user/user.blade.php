@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{ $user->name }}</h1></div>
                <div class="panel-body">
                    <h3>Recent Uploads</h3>
                    <div class="index-gallery">
                    @foreach ($uploads as $p)

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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
