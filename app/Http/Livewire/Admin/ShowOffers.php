<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Offer;

class ShowOffers extends Component
{
    public $user;
    public $isOpen = false;
    public $name;
    public $geo;
    public $payout;
    public $offer_id;
    public $mode = 'create';

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function storeOffer()
    {
        // Validate and store the new offer
        $this->validate([
            'name' => 'required',
            'geo' => 'required',
            'payout' => 'required|numeric',
        ]);

        $this->user->offers()->create([
            'name' => $this->name,
            'geo' => $this->geo,
            'payout' => $this->payout,
        ]);

        // Reset the form fields and close the modal
        $this->reset('name', 'geo', 'payout');
        $this->isOpen = false;
        $this->mode = 'create';
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);

        $this->offer_id = $id;
        $this->name = $offer->name;
        $this->geo = $offer->geo;
        $this->payout = $offer->payout;

        $this->mode = 'edit';
        $this->openModal();
    }

    public function updateOffer()
    {
        // Validate and update the offer
        $this->validate([
            'name' => 'required',
            'geo' => 'required',
            'payout' => 'required|numeric',
        ]);

        $offer = Offer::findOrFail($this->offer_id);
        $offer->update([
            'name' => $this->name,
            'geo' => $this->geo,
            'payout' => $this->payout,
        ]);

        // Reset the form fields and close the modal
        $this->reset('name', 'geo', 'payout');
        $this->isOpen = True;
        $this->mode = 'create';
        session()->flash('message', 'Successfully updated.');


    }

    public function delete($id)
    {
        $offer = Offer::find($id);
        $offer->delete();
    }

    public function render()
    {
        return view('livewire.admin.show-offers', [
            'offers' => $this->user->offers()->paginate(10),
        ]);
    }
}
