<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class AuditLog extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'user_id',
        'action',
        'target_type',
        'target_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeeks(2));
    }
    
}

