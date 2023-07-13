<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Offer;
use App\Models\Doc;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_nick_name',
        'company_email',
        'company_address',
        'contact_person',
        'contact_person_email',
        'contact_person_phone_number',
        'onboarded_by',
        'relation',
        'payment_terms',
        'is_approved'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }
}
