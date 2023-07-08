<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'geos',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
