<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Account as AccountModel;


class Account extends Component
{
    public $accounts, $name,  $account_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->accounts = AccountModel::all();
        return view('livewire.account');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->name = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        AccountModel::updateOrCreate(['id' => $this->account_id], [
            'name' => $this->name,
        ]);

        session()->flash('message', $this->account_id ? 'Account updated.' : 'Account created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $account = AccountModel::findOrFail($id);
        $this->account_id = $id;
        $this->name = $account->name;

        $this->openModalPopover();
    }

    public function delete($id)
    {
        AccountModel::find($id)->delete();
        session()->flash('message', 'Account deleted.');
    }
}
