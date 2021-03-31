@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">{{ isset($user) ? 'Update a user': 'Create a new user' }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif

            <form method="post" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
                @method( isset($user) ? 'PUT' : 'POST' )
                @csrf

                <div class="form-group">
                    <label for="first_name">Name:</label>
                    <input class="form-control @error('name') 'is-danger' @enderror"
                           type="text"
                           name="name"
                           id="name"
                           value="{{ isset($user) ? $user->name : old('name') }}" />us
                    @error('name')
                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Mail:</label>
                    <input class="form-control @error('email') 'is-danger' @enderror"
                           type="text"
                           name="email"
                           id="email"
                           value="{{ isset($user) ? $user->email : old('email') }}" />
                    @error('email')
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Role:</label>
                    <input class="form-control @error('role') 'is-danger' @enderror"
                           type="text"
                           name="role"
                           id="role"
                           value="{{ isset($user) ? $user->role : old('role') }}" />
                    @error('role')
                        <p class="help is-danger">{{ $errors->first('role') }}</p>
                    @enderror
                </div>

                <button type="submit" class="uppercase btn btn-primary">{{ isset($user) ? 'Update': 'Create' }}</button>
                <button type="cancel" class="uppercase btn btn-primary" onclick="document.history.back();">Cancel</button>
            </form>
        </div>
    </div>
@endsection
