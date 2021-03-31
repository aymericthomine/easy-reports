@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">

            <label for="first_name">Name: {{ $user->name }}</label>

            <label for="last_name">Mail: {{ $user->email }}</label>

            <label for="email">Role: {{ $user->role }}</label>

        </div>
    </div>
@endsection
