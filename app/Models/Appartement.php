<?php

namespace App\Models;

use App\Models\AppartDoc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appartement extends Model
{
    use HasFactory;
    protected $fillable = [
        'appartement_code',
        'property_code',
        'title',
        'price',
        'available',
        'appartType',
        'bedroomsNumber',
        'bathroomsNumber',
        'CommoditiesHomesafety',
        'CommoditiesBedroom',
        'CommoditiesKitchen',
        'video_url',
        'main_image',
        'description',
        'updated_by',
        'created_by',
        'deleted_by',
        'etat',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_code', 'property_code');
    }
    public function images()
    {
        return $this->hasMany(AppartDoc::class, 'appartement_code', 'appartement_code');
    }
}