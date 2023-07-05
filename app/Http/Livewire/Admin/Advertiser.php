<?php
namespace App\Http\Livewire\Admin;
use Illuminate\Support\Facades\Hash;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Advertiser extends Component
{
    use WithPagination;

    public $name, $email,$user_id;
    public $isOpen = 0;
    public $mode = 'create';

    public function render()
    {
        return view('livewire.admin.advertiser', [
            'advertisers' => User::paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->mode = 'create';
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;

    }
    public function openModals()
    {
        $this->isOpen = true;
        $this->resetInputFields();

    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->user_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('defaultPassword'),

        ]);

        session()->flash('message', $this->user_id ? 'Advertiser updated successfully.' : 'Advertiser created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->mode = 'edit';
        $this->openModal();
    }
    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Advertiser deleted successfully.');
    }
}

