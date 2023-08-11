<?php

namespace App\Http\Livewire\Admin;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Laravel\Jetstream\HasTeams;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CompanyNotification;

class CompanyComponent extends Component
{
    use WithPagination;

    public   $company_name, $company_nick_name, $company_email, $company_address,
             $contact_person, $contact_person_email, $contact_person_phone_number,
             $onboarded_by, $is_approved;
    public $isOpen, $relation = 0;
    public $mode = 'create';
    public $company_id;
    public $payment_terms = 'prepaid';
    public $userRole;
    public $role;
    public $is_approved_filter = null;

    public function render()
    {
        $user = Auth::user();
        $currentTeam = $user->currentTeam;

        if ($currentTeam) {
            $this->userRole = $user->teamRole($currentTeam)->name;
        } else {
            $this->userRole = null;
        }

        // If $relation is set, filter by it; otherwise, fetch all companies
        if ($this->relation !== null) {
            $companys = Company::where('relation', $this->relation)->paginate(10);
        } else {
            $companys = Company::paginate(10);
        }

        if ($this->is_approved_filter !== null) {
            $companys = Company::where('is_approved', $this->is_approved_filter)->paginate(10);
        } else {
            $companys = Company::paginate(10);
        }

        return view('livewire.admin.company-component', [
            'companys' => $companys
        ]);
    }

    public function getRoleName($role)
    {
        $roles = [
            '0' => 'Advertiser',
            '1' => 'Publisher',
            '2' => 'Aggregator',
        ];

        return $roles[$role] ?? 'Select Role';
    }

    //api method
    public function getCompanyNames()
    {
        $companyNames = Company::pluck('company_name');
        return response()->json($companyNames);
    }

    //api method for offers associated with company name
    public function getOffersByCompanyName($name)
    {
        $company = Company::with(['offers'])->where('company_name', $name)->first();

        if ($company) {
            $offers = $company->offers->map(function ($offer) {
                return [
                    'names' => $offer->name,
                    'operators' => $offer->operators,
                    'service_name' => $offer->service_name,
                    'geo' => $offer->geo,
                    'payout' => $offer->payout,
                ];
            });

            return response()->json($offers);
        } else {
            return response()->json(['message' => 'Company not found'], 404);
        }
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

    public function filter($role)
    {
        // Update the relation to the selected role
        $this->relation = $role;

        // Reset pagination to the first page
        $this->resetPage();
    }


    public function openModals()
    {
        $this->isOpen = true;
        $this->resetInputFields();
        $this->mode = 'create';
    }

    public function store()
    {
        if (is_null($this->relation)) {
            $this->relation = 0;
        }
        $this->validate([
            'company_name' => 'required|max:255',
            'company_email' => 'required|email|max:255|unique:companies,company_email,' . $this->company_id,
            'company_address' => 'nullable|max:255',
            'contact_person' => 'nullable|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'relation' => 'required|in:0,1,2',
            'company_nick_name' => 'nullable|max:255',
            'contact_person_phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'onboarded_by' => 'nullable|max:255',
            'payment_terms' => 'required|in:prepaid,days7,days15,days30,days60,days90',
        ]);

        $company = Company::updateOrCreate(['id' => $this->company_id], [
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

        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new CompanyNotification($company));
        }

        session()->flash('message', $this->company_id ? 'Company updated successfully.' : 'Company created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }


    public function closeModal()
    {
        $this->isOpen = false;
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
