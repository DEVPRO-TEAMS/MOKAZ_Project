<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenoms',
        'email',
        'phone',
        'room_id',
        'start_time',
        'end_time',
        'statut_paiement',
        'status',
        'traited_by',
        'traited_at',
        'notes',
        'unit_price',
        'total_price',
    ];

    
}

