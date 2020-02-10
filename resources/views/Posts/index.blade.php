@extends('layouts.app')

@section('content')
<h1>All posts</h1>

<div class="container">
    @if(count($posts)>0)
    @foreach ($posts as $post)
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    <a href="/posts/{{$post->id}}"> Post {{$post->id}} </a>
                </div>
                <div class="card-body" style=" height: 300;">
                    {{$post->content}}
                    <br>
                    @if ($post->attachment != NULL)
                         <img style="width:400px; height: auto;overflow: hidden;" src="{{ asset('storage/images/post_images/'.$post->attachment) }}"
                        alt="post {{$post->id}} attachment">
                    @endif


                </div>
            </div>
        </div>
    </div>
    <br>
    @endforeach
    {{$posts -> links()}}
    @else
    <p>No Posts Here!</p>
    @endif
</div>
@endsection
