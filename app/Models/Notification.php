<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Application;

class JobAppliedNotification extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        // Save to database (you can add mail later if needed)
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toDatabase($notifiable)
    {
        $job = $this->application->job;
        $applicant = $this->application->user;

        return [
            'type' => 'job_applied',
            'job_id' => $job->id,
            'job_title' => $job->title,
            'applicant_id' => $applicant->id,
            'applicant_name' => $applicant->name,
            'message' => "{$applicant->name} has applied for your job: {$job->title}.",
            'url' => route('employer.jobs.applicants', $job->id), // Link to applicants
        ];
    }
}