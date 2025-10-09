<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'resume',
        'cover_letter',
        'status',
    ];

    /**
     * The job seeker who submitted the application.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * The job this application belongs to.
     */
    public function job()
    {
        return $this->belongsTo(\App\Models\Job::class);
    }
}
