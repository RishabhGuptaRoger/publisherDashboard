<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompanyController extends Controller
{
    public function approve(Company $company)
    {
        $company->update(['is_approved' => true]);
        return redirect()->route('dashboard')->with('message', 'Company approved!');
    }

    public function disapprove(Company $company)
    {
        $company->update(['is_approved' => false]);
        return redirect()->route('dashboard')->with('message', 'Company disapproved.');
    }
}

