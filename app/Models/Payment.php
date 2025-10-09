<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'amount',
        'transaction_id',
        'screenshot',
        'status',
    ];

    /**
     * Payment belongs to a User (Employer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payment belongs to a Job.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}