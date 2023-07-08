<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Doc;
use Illuminate\Support\Facades\Storage;
use Exception;

class ShowDocs extends Component
{
    use WithFileUploads;

    public $user;
    public $isOpen = false;
    public $start_date;
    public $end_date;
    public $geos = 'all';
    public $doc_id;
    public $mode = 'create';

    public $file;
    public $uploadSuccessful = false;

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
            'file' => 'file|max:1024000', // 1000MB Max
        ]);

        if($this->file) {
            $filePath = $this->file->store('advertiser', 'public');

            $this->user->doc()->create([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'geos' => $this->geos,
                'file_path' => $filePath, // Store the file path
            ]);

            $this->reset('start_date', 'end_date', 'geos', 'file');
            $this->isOpen = false;
            $this->mode = 'create';
            $this->uploadSuccessful = true; // Set uploadSuccessful to true

            session()->flash('message', 'Document successfully saved.');
        } else {
            session()->flash('error', 'File is required.');
        }
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
            'file' => 'file|max:1024000', // 1000MB Max
        ]);

        if($this->file) {

            $doc = Doc::findOrFail($this->doc_id);


            // Upload new file
            $filePath = $this->file->store('advertiser', 'public'); // Store the file

            $doc->update([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'geos' => $this->geos,
                'file_path' => $filePath, // Store the file path
            ]);

            $this->reset('start_date', 'end_date', 'geos', 'file');
            $this->isOpen = false;
            $this->mode = 'create';
            $this->uploadSuccessful = true; // Set uploadSuccessful to true

            session()->flash('message', 'Document successfully updated.');
        } else {
            session()->flash('error', 'File is required.');
        }
    }

    public function delete($id)
    {
        try {
            $doc = Doc::find($id);

            // Delete the file associated with the doc
            if (Storage::disk('public')->exists($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }

            $doc->delete();

            session()->flash('message', 'Document successfully deleted.');
        } catch (Exception $e) {
            session()->flash('error', 'There was an error deleting the document: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.show-docs', [
            'docs' => $this->user->doc()->paginate(10),
        ]);
    }
}
