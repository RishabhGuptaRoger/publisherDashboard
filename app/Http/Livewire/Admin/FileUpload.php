<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $uploadSuccessful = false;

    public function save()
    {
        $this->validate([
            'file' => 'required|file|max:1024000', // 1000MB Max
        ]);

        $this->file->store('advertiser', 'public');

        $this->uploadSuccessful = true;
    }

    public function render()
    {
        return view('livewire.admin.file-upload');
    }
}

