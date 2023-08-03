<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'operators',
        'service_name',
        'geo',
        'payout',
    ];

    /**
     * Get the user that owns the offer.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
