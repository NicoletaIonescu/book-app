<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\User as UserModel;
use Spatie\Permission\Models\Role;


class Users extends Component
{
    public $users, $name, $email, $user_id, $all_roles, $role;
    public $isModalOpen = 0;
    public $isModelAssignOpen = 0;

    public function render()
    {
        $this->all_roles = Role::all();
        $this->users = UserModel::all();
        return view('livewire.users');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalAssignPopover()
    {
        $this->isModelAssignOpen = true;
    }

    public function closeModalAssignPopover()
    {
        $this->isModelAssignOpen = false;
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm()
    {
        $this->name = '';
        $this->email = '';
    }

    private function resetAssignForm()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        UserModel::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('message', $this->user_id ? 'User updated.' : 'User created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->openModalPopover();
    }

    public function delete($id)
    {
        UserModel::find($id)->delete();
        session()->flash('message', 'User deleted.');
    }

    public function assign($id)
    {
        $user = UserModel::findOrFail($id);
        $this->all_roles = Role::all();
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->openModalAssignPopover();
    }

    public function assignRole(){
        $this->validate([
            'role' => 'required',
        ]);

        $user = UserModel::findOrFail($this->user_id);
        $user->assignRole($this->role);
        session()->flash('message', "User role added");

        $this->closeModalAssignPopover();
        $this->resetAssignForm();

    }
}
