<?php

namespace App\Models;

use App\Models\AppartDoc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appartement extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'code',
        'property_uuid',
        'image',
        'title',
        'description',
        'type_uuid',
        'commodity_uuid',
        'nbr_room',
        'nbr_bathroom',
        'nbr_available',
        'video_url',
        'updated_by',
        'created_by',
        'deleted_by',
        'etat',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_uuid', 'uuid');
    }
    public function images()
    {
        return $this->hasMany(AppartDoc::class, 'appartement_code', 'appartement_code');
    }
    public function tarifications()
    {
        return $this->hasMany(Tarification::class, 'appartement_code', 'appartement_code');
    }
}