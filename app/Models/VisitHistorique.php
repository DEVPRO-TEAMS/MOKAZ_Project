<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitHistorique extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'visit_uuid',
        'source',        // direct, seo, social, ads, email
        'referrer',
        'coordornneGPS', // latitude, longitude
        'country',
        'city',
        'started_at',
        'last_activity_at',
        'ended_at',
        'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];
}
