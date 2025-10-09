<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'company',
        'location',
        'employment_type',
        'salary_min',
        'salary_max',
        'skills',
        'description',
        'is_featured',
        'status',
        'is_premium',
        'premium_expires_at',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_featured' => 'boolean',
        'is_premium' => 'boolean',
        'premium_expires_at' => 'datetime',
    ];

    /**
     * The employer who posted the job.
     */
    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The job seekers who have applied to this job.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Check if job is currently premium.
     */
    public function isPremium()
    {
        return $this->is_premium && $this->premium_expires_at && $this->premium_expires_at->isFuture();
    }

    /**
     * Query scope for active premium jobs.
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true)
                     ->where('premium_expires_at', '>', Carbon::now());
    }
}