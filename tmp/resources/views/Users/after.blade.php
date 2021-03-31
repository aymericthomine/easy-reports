<!-- Modal -->
<div x-show="openModal"
     x-on:close-modal.window="openModal = false"
     x-on:open-modal.window="openModal = true"
>
    <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
            x-on:click="openModal = false">
        </div>
            <div class="modal-container bg-white w-5/6 md:max-w-2xl mx-auto rounded shadow-lg z-50 overflow-y-auto cursor-auto">
                <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                </div>

            <div class="modal-content py-4 text-left px-6">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ isset($user_id) ? 'Update': 'Create' }}</h5>
                    <button x-on:click="openModal = false" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @method( isset($user_id) ? 'PUT' : 'POST' )
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control @error('name') 'is-danger' @enderror"
                                   type="text"
                                   id="name"
                                   value="{{ old('name') }}"
                                   wire:model.lazy="name"
                            />
                            @error('name')
                            <p class="help is-danger">{{ $errors->first('name') }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Mail:</label>
                            <input class="form-control @error('email') 'is-danger' @enderror"
                                   type="text"
                                   id="email"
                                   value="{{ old('email') }}"
                                   wire:model.lazy="email"
                            />
                            @error('email')
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">Role:</label>
                            <input class="form-control @error('role') 'is-danger' @enderror"
                                   type="text"
                                   id="role"
                                   value="{{ old('role') }}"
                                   wire:model.lazy="role"
                            />
                            @error('role')
                            <p class="help is-danger">{{ $errors->first('role') }}</p>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button wire:click="{{ isset($user_id) ? 'update()' : 'store()' }}" type="button" class="btn btn-primary">Save changes</button>
                            <button x-on:click="openModal = false" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-black hover:bg-indigo-400">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



