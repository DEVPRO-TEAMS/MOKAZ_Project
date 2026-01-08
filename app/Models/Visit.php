<?php

namespace App\Models;

use App\Models\PageView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'ip_address',
        'user_agent',
        'source',        // direct, seo, social, ads, email
        'referrer',
        'coordornneGPS',
        'country',
        'city',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function pageViews()
    {
        return $this->hasMany(PageView::class, 'visit_uuid', 'uuid');
    }
}
