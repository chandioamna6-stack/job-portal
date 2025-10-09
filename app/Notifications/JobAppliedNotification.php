<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class JobAppliedNotification extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
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
        return ['database', 'mail']; // store in database and send email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Job Application')
                    ->line('A new application has been submitted for your job: ' . $this->application->job->title)
                    ->action('View Application', url('/employer/jobs/' . $this->application->job->id . '/applicants'))
                    ->line('Thank you for using our job portal!');
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_id' => $this->application->job->id,
            'job_title' => $this->application->job->title,
            'applicant_name' => $this->application->user->name,
            'message' => $this->application->user->name . ' applied for your job: ' . $this->application->job->title,
        ];
    }
}