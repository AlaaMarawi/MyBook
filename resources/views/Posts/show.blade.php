@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Post</div>
                <div class="card-body">
                    {{$post->content}}<br>
                    @if ($post->attachment != NULL)
                    <img style="width:100%" src="{{ asset('storage/images/post_images/'.$post->attachment) }}"><br>
                    @endif
                    <small>created at {{$post->created_at}}</small><br>
                    <small>updated at {{$post->updated_at}}</small><br>
                    <small>written by {{$post->user->first_name}}</small><br>


                </div>
            </div>
        </div>
        <div class="col-md-2">
            <a href="/posts" class="btn btn-default">Go Back</a>
            <br>
            @if (!Auth::guest())
                @if (Auth::user()->id == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit Post</a>
                {{-- delete post --}}
                {!!Form::open(['action'=> ['PostController@destroy', $post->id], 'method' => 'POST', 'class' =>
                'pull-right']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete Post',['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
                @endif
            @endif


        </div>
    </div>


</div>


@endsection
