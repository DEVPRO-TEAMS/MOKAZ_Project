<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarification extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'code',
        'appartement_code',
        'sejour_en',
        'temps',
        'prix',
        'updated_by',
        'created_by',
        'deleted_by',
        'etat',
    ];
    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }
}

