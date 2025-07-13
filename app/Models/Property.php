<?php

namespace App\Models;

use App\Models\city;
use App\Models\country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_code',
        'partner_code',
        'image_property',
        'title',
        'address',
        'zipCode',
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

}
