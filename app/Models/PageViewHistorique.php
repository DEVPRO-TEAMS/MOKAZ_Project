<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageViewHistorique extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'pageview_uuid',
        'started_at',
        'ended_at',
        'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function pageView()
    {
        return $this->belongsTo(PageView::class, 'pageview_uuid', 'uuid');
    }
}
