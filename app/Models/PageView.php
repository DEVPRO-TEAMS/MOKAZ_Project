<?php

namespace App\Models;

use App\Models\Visit;
use App\Models\Appartement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageView extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_uuid',
        'url',
        'page_type', // home, search, appartement, login
        'appartement_uuid',
        'duration',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_uuid', 'uuid');
    }

    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'appartement_uuid', 'uuid');
    }

}
