<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
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
