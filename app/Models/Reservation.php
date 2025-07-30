<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'nom',
        'prenoms',
        'email',
        'phone',
        'appart_uuid',
        'sejour',
        'start_time',
        'end_time',
        'nbr_of_sejour',
        'total_price',
        'unit_price',
        'statut_paiement',
        'status',
        'notes',
        'traited_by',
        'traited_at',
        'etat',
    ];


    
}

