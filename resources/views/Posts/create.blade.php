@extends('layouts.app')

@section('content')
    <h1>Create New Post</h1>
    {!! Form::open(['action' => 'PostController@store' , 'method' => 'POST','enctype' => 'multipart/form-data']) !!}
        <div class ="form-group" >
            {{Form::label('categ','Category')}} {{-- label(attr, val) --}}
            {{Form::text('categ','', ['class' => 'form-control', 'placeholder' => 'text'])}}{{-- [attr.s] //form-cont: bootstrp class --}}
        </div>
        <div class ="form-group" >
            {{Form::label('content','Content')}}
            <textarea rows="4", cols="54" id="content" name="content" style="resize:none," class="form-control"></textarea>

            <!-- can use mixed larav.collective and html tags{{Form::textarea('content','', ['class' => 'form-control'])}} -->
        </div>
        <div class='from-group'>
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit', ['class'=> 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
