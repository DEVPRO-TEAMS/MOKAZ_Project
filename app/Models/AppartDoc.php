<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppartDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'appartement_code',
        'doc_name',
        'doc_url',
    ];
}
