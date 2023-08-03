<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Company;
use App\Models\Offer;

class ShowOffers extends Component
{
    public $company;
    public $isOpen = false;
    public $name;
    public $operators;
    public $service_name;
    public $geo = 'all';
    public $payout;
    public $offer_id;
    public $mode = 'create';

    public function mount(company $company)
    {
        $this->company = $company;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function openModals()
    {
        $this->isOpen = true;
        $this->reset('name','operators','service_name', 'geo', 'payout');
        $this->mode = 'create';
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
            'operators'=> 'required',
            'service_name' => 'required',
            'geo' => 'required',
            'payout' => 'required|numeric',
        ]);

        $this->company->offers()->create([
            'name' => $this->name,
            'operators' => $this->operators,
            'service_name' => $this->service_name,
            'geo' => $this->geo,
            'payout' => $this->payout,
        ]);

        // Reset the form fields and close the modal
        $this->reset('name','operators','service_name', 'geo', 'payout');
        $this->isOpen = false;
        $this->mode = 'create';

        // Flash message
        session()->flash('message', 'Offer successfully created.');
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);

        $this->offer_id = $id;
        $this->name = $offer->name;
        $this->operators = $offer->operators;
        $this->service_name = $offer->service_name;
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
            'operators'=> 'required',
            'service_name' => 'required',
            'geo' => 'required',
            'payout' => 'required|numeric',
        ]);

        $offer = Offer::findOrFail($this->offer_id);
        $offer->update([
            'name' => $this->name,
            'operators' => $this->operators,
            'service_name' => $this->service_name,
            'geo' => $this->geo,
            'payout' => $this->payout,
        ]);

        $this->isOpen = True;
        $this->mode = 'edit';

        // Flash message
        session()->flash('message', 'Successfully updated.');
    }

    public function delete($id)
    {
        $offer = Offer::find($id);
        $offer->delete();

        // Flash message
        session()->flash('message', 'Offer successfully deleted.');
    }

    public function render()
    {
        return view('livewire.admin.show-offers', [
            'offers' => $this->company->offers()->paginate(10),
        ]);
    }
}
