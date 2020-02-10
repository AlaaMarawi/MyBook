@extends('layouts.app')

@section('content')
<div class="container">
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
                    You are logged in! <br>
                    <a href="/posts/create" class='btn btn-primary '>Create a Post</a>
                    <br><br>
                    <h2>Your Posts</h2>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
