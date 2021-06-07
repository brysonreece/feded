<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'school_id',
        'name',
        'locale',
        'street',
        'city',
        'state',
        'zip',
        'latitude',
        'longitude',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
