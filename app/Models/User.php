<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ Role assignment
        'phone',
        'address',
        'country',
        'bank_name',
        'account_number',
        'avatar', // ✅ profile picture
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Jobs that the user has saved.
     */
    public function savedJobs()
    {
        return $this->belongsToMany(
            \App\Models\Job::class,
            'saved_jobs',
            'user_id',
            'job_id'
        )->withTimestamps();
    }

    /**
     * Job applications submitted by the user (job seeker).
     */
    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

    /**
     * Messages sent by this user.
     */
    public function sentMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'sender_id');
    }

    /**
     * Messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'receiver_id');
    }
}