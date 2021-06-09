<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory, Searchable;

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
    
    public function getLocaleDescription()
    {
        switch ($this->locale) {
            case 11: return 'City, Large';
            case 12: return 'City, Midsize';
            case 13: return 'City, Small';
            case 21: return 'Suburban, Large';
            case 22: return 'Suburban, Midsize';
            case 23: return 'Suburban, Small';
            case 31: return 'Town, Fringe';
            case 32: return 'Town, Distant';
            case 33: return 'Town, Remote';
            case 41: return 'Rural, Fringe';
            case 42: return 'Rural, Distant';
            case 43: return 'Rural, Remote';
            default: return null;
        }
    }
}
