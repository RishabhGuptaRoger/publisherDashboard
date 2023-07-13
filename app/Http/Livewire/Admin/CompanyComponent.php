<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyComponent extends Component
{
    use WithPagination;

    public $company_name, $company_nick_name, $company_email, $company_address, $contact_person, $contact_person_email, $contact_person_phone_number, $onboarded_by, $is_approved;
    public $isOpen ,$relation= 0;
    public $mode = 'create';
    public $company_id;
    public $payment_terms = 'prepaid';

    public function render()
    {
        return view('livewire.admin.company-component', [
            'companys' => Company::paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->mode = 'create';
        $this->openModal();
    }

    private function resetInputFields()
    {
        $this->company_name = '';
        $this->company_nick_name = '';
        $this->company_email = '';
        $this->company_address = '';
        $this->contact_person = '';
        $this->contact_person_email = '';
        $this->contact_person_phone_number = '';
        $this->onboarded_by = '';
        $this->relation = '0';
        $this->payment_terms = 'prepaid';
        $this->is_approved = '';
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function toggleApproval($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['is_approved' => !$company->is_approved]);
    }


    public function openModals()
    {
        $this->isOpen = true;
        $this->resetInputFields();
        $this->mode = 'create';
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        if (is_null($this->relation)) {
            $this->relation = 0;
        }
        $this->validate([
            'company_name' => 'required|max:255',
            'company_email' => 'required|email|max:255|unique:companies,company_email,'.$this->company_id,
            'company_address' => 'nullable|max:255',
            'contact_person' => 'nullable|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'relation' => 'required|in:0,1,2',
            'company_nick_name' => 'nullable|max:255',
            'contact_person_phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'onboarded_by' => 'nullable|max:255',
            'payment_terms' => 'required|in:prepaid,days7,days15,days30,days60,days90',
        ]);

        Company::updateOrCreate(['id' => $this->company_id], [
            'company_name' => $this->company_name,
            'company_nick_name' => $this->company_nick_name,
            'company_email' => $this->company_email,
            'company_address' => $this->company_address,
            'contact_person' => $this->contact_person,
            'contact_person_email' => $this->contact_person_email,
            'contact_person_phone_number' => $this->contact_person_phone_number,
            'onboarded_by' => $this->onboarded_by,
            'relation' => $this->relation,
            'payment_terms' => $this->payment_terms,
        ]);


        session()->flash('message', $this->company_id ? 'Company updated successfully.' : 'Company created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $this->company_id = $id;
        $this->company_name = $company->company_name;
        $this->company_nick_name = $company->company_nick_name;
        $this->company_email = $company->company_email;
        $this->company_address = $company->company_address;
        $this->contact_person = $company->contact_person;
        $this->contact_person_email = $company->contact_person_email;
        $this->contact_person_phone_number = $company->contact_person_phone_number;
        $this->onboarded_by = $company->onboarded_by;
        $this->relation = $company->relation;
        $this->payment_terms = $company->payment_terms;
        $this->mode = 'edit';
        $this->openModal();
    }

    public function delete($id)
    {
        Company::find($id)->delete();
        session()->flash('message', 'Company deleted successfully.');
    }
}
