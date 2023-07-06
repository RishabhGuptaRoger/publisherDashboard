<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Doc;

class ShowDocs extends Component
{
    public $user;
    public $isOpen = false;
    public $start_date;
    public $end_date;
    public $geos = 'all';
    public $doc_id;
    public $mode = 'create';

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function openModals()
    {
        $this->isOpen = true;
        $this->reset('start_date', 'end_date', 'geos');
        $this->mode = 'create';
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function storeDoc()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'geos' => 'required',
        ]);

        $this->user->doc()->create([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'geos' => $this->geos,
        ]);

        $this->reset('start_date', 'end_date', 'geos');
        $this->isOpen = false;
        $this->mode = 'create';
    }

    public function edit($id)
    {
        $doc = Doc::findOrFail($id);

        $this->doc_id = $id;
        $this->start_date = $doc->start_date;
        $this->end_date = $doc->end_date;
        $this->geos = $doc->geos;

        $this->mode = 'edit';
        $this->openModal();
    }

    public function updateDoc()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'geos' => 'required',
        ]);

        $doc = Doc::findOrFail($this->doc_id);
        $doc->update([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'geos' => $this->geos,
        ]);

        $this->reset('start_date', 'end_date', 'geos');
        $this->isOpen = false;
        $this->mode = 'create';
    }

    public function delete($id)
    {
        $doc = Doc::find($id);
        $doc->delete();
    }

    public function render()
    {
        return view('livewire.admin.show-docs', [
            'docs' => $this->user->doc()->paginate(10),
        ]);
    }
}
