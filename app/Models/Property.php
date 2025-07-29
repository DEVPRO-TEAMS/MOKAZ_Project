<?php

namespace App\Models;

use App\Models\city;
use App\Models\country;
use App\Models\Appartement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'partner_uuid',
        'image',
        'title',
        'type_uuid',
        'address',
        'country',
        'city',
        'longitude',
        'latitude',
        'description',
        'updated_by',
        'created_by',
        'deleted_by',
        'etat',
    ];

    public function pays()
    {
        return $this->belongsTo(country::class, 'country', 'code');
    }
    public function ville()
    {
        return $this->belongsTo(city::class, 'city', 'code');
    }


    public function apartements()
    {
        return $this->hasMany(Appartement::class, 'property_code', 'property_code');
    }

}
