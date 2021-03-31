 <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ isset($user_id) ? 'Update': 'Create' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-8 offset-sm-2">

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

                    <form method="post" action="{{ isset($user_id) ? route('users.update', $user_id) : route('users.store') }}">
                            @method( isset($user_id) ? 'PUT' : 'POST' )
                            @csrf

                        <div class="form-group">
                            <label for="first_name">Name:</label>
                            <input class="form-control @error('name') 'is-danger' @enderror"
                                                           type="text"
                                                           name="name"
                                                           id="name"
                                                           value="{{ isset($user_id) ? $name : old('name') }}" />
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
                                                           value="{{ isset($user_id) ? $email : old('email') }}" />
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
                                                           value="{{ isset($user_id) ? $role : old('role') }}" />
                            @error('role')
                            <p class="help is-danger">{{ $errors->first('role') }}</p>
                            @enderror
                        </div>

                        <button type="button" class="btn btn-primary">{{ isset($user_id) ? 'Update': 'Create' }}</button>
                        <button type="cancel" class="btn btn-primary" onclick="document.history.back();">Cancel</button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click="edit({{ $user_id }})" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>


