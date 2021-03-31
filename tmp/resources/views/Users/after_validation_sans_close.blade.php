 <!-- Modal -->
 <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ isset($user_id) ? 'Update': 'Create' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-8 offset-sm-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach

                                    {{ $current }}
                        </div>
                        <br />
                    @endif
                </div>
 <!--               <form wire:submit.prevent="store" method="post" >
                        @method( isset($user_id) ? 'PUT' : 'POST' )
                        @csrf
-->
                <form>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input class="form-control @error('name') 'is-danger' @enderror"
                               type="text"
                               name="name"
                               id="name"
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
                               name="email"
                               id="email"
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
                               name="role"
                               id="role"
                               wire:model.lazy="role"
                        />
                        @error('role')
                        <p class="help is-danger">{{ $errors->first('role') }}</p>
                        @enderror
                    </div>
                </form>

                <div class="modal-footer">
                        <button wire:click.prevent="store()" type="button" class="btn btn-primary" disabled="disabled">Save changes</button>
                    <button wire:focus="store()" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-black hover:bg-indigo-400" @click="showModal = false">Close</button>
                </div>
<!--                </form>
-->
            </div>
        </div>
    </div>
</div>


