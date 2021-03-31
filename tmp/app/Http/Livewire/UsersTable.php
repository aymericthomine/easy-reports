<?php

namespace App\Http\Livewire;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UsersTable extends LivewireDatatable
{
    public $model = User::class;
    public $user;
    public $user_id;
    public $name;
    public $email;
    public $role;
    public $password = "toto";

    public function columns()
    {
        return [
            Column::callback(['id'], function ($id) {
                return view('users.actions', ['id' => $id]);
            }),

            NumberColumn::name('id')->filterable()->defaultSort('asc'),

            Column::name('name')->filterable()->searchable()->editable()->defaultSort('asc'),

            Column::name('email')->filterable()->searchable()->editable()->defaultSort('asc'),
        ];
    }

    /*
     * Attention: peut provoquer 502 Bad gateway

    public function render()
    {
        // return view('users.test')->layout('layouts.default');
        // return view('users.index')->layout('layouts.default');
    }
     */
    private function resetInputFields()
    {
        $this->resetErrorBag();
        $this->user_id = null;
        $this->name = null;
        $this->email = null;
        $this->role = null;
    }

    public function openModal()
    {
        $this->dispatchBrowserEvent('open-modal');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
        // ou si pas de Modal
        // return view('users.create-or-update' );
    }

    public function edit($id)
    {
        $this->user = User::findOrFail($id);
        $this->resetInputFields();
        $this->user_id = $id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
        $this->openModal();
        // ou si pas de Modal
        // return view('users.create-or-update', compact('user'));
    }

    public function store()
    {
        User::create($this->validate(User::validationRules()));
        $this->closeModal();
        // ou si pas de Modal
        // return redirect(route('users.index'))->with('success', 'User created !');
    }

    public function update()
    {
        $this->user->update($this->validate(User::validationRules()));
        $this->closeModal();
        // ou si pas de Modal
        // return redirect(route('users.index'))->with('success', 'User updated !');
    }

    public function destroy(User $user)
    {
        $user->delete();
        // refresh pas necessaire sauf pour le message de suppression:
        // return redirect(route('users.index'))->with('success', 'User deleted !');
    }
}
