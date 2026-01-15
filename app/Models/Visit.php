<?php

namespace App\Models;

use App\Models\PageView;
use App\Models\VisitHistorique;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'ip_address',
        'user_agent',
        'started_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
    ];

    public function pageViews()
    {
        return $this->hasMany(PageView::class, 'visit_uuid', 'uuid');
    }

    // public function getDurationAttribute()
    // {
    //     if (!$this->ended_at) {
    //         return now()->diffInSeconds($this->started_at);
    //     }

    //     return $this->ended_at->diffInSeconds($this->started_at);
    // }

    public function historiques()
    {
        return $this->hasMany(VisitHistorique::class , 'visit_uuid', 'uuid');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('started_at', today());
    }
    
    public function scopeActive($query)
    {
        return $query->whereHas('historiques', function ($q) {
            $q->whereNull('ended_at');
        });
    }
    
    public function getTotalDurationAttribute()
    {
        return $this->historiques->sum('duration');
    }
}
