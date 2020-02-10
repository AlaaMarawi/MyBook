@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Timeline</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <a href="/posts/create" class='btn btn-primary '>Create a Post</a>
                </div>
            </div>
            <br>
            @if(count($posts)>0)
            @foreach ($posts as $post)
            <div class="card">
                <div class="card-header">
                    <a href="/posts/{{$post->id}}"> Post {{$post->id}} </a>
                </div>
                <div class="card-body">
                    {{$post->content}}
                    @if ($post->attachment != NULL)
                    <br>
                    <img style="width:100%" src="{{ asset('storage/cover_images/'.$post->attachment) }}"><br>
                    @endif
                </div>
            </div>
            <br>
            @endforeach
            {{--$posts -> links()--}}
            @else
            <p>No Posts Here!</p>
            @endif

        </div>
    </div>
</div>


@endsection
