@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>

    {!! Form::open(['action' => ['PostController@update',$post->id] ,
     'method' => 'POST','enctype' => 'multipart/form-data']) !!}
        <div class ="form-group" >
            {{Form::label('categ','Category')}}
            {{Form::text('categ',$post->categories, ['class' => 'form-control',
             'placeholder' => 'text'])}}
        </div>
        <div class ="form-group" >
            {{Form::label('content','Content')}}
            {{Form::textarea('content',$post->content, ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class'=> 'btn btn-primary'])}}
        {{Form::hidden('_method', 'PUT')}}
    {!! Form::close() !!}

@endsection

