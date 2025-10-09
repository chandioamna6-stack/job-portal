<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class ApplicationController extends Controller
{
    /**
     * Job seeker applies to a job
     */
    public function store(Request $request, Job $job)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        $application = Application::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'resume' => $resumePath,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        // Notify the employer
        $employer = User::find($job->user_id);
        NotificationFacade::send($employer, new SystemNotification(
            'New Job Application',
            [
                'message' => Auth::user()->name . ' applied to your job: ' . $job->title,
                'job_id' => $job->id,
                'application_id' => $application->id,
            ]
        ));

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    /**
     * Show applications of logged-in job seeker
     */
    public function myApplications()
    {
        $applications = Application::where('user_id', Auth::id())
            ->with('job')
            ->latest()
            ->paginate(10);

        return view('jobseeker.my-applications', compact('applications'));
    }

    /**
     * Employer accepts an application
     */
    public function accept(Application $application)
    {
        if ($application->job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update(['status' => 'accepted']);

        // Notify the job seeker
        $jobSeeker = User::find($application->user_id);
        NotificationFacade::send($jobSeeker, new SystemNotification(
            'Application Accepted',
            [
                'message' => 'Your application for "' . $application->job->title . '" has been accepted.',
                'job_id' => $application->job->id,
                'application_id' => $application->id,
            ]
        ));

        return back()->with('success', 'Application accepted.');
    }

    /**
     * Employer rejects an application
     */
    public function reject(Application $application)
    {
        if ($application->job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update(['status' => 'rejected']);

        // Notify the job seeker
        $jobSeeker = User::find($application->user_id);
        NotificationFacade::send($jobSeeker, new SystemNotification(
            'Application Rejected',
            [
                'message' => 'Your application for "' . $application->job->title . '" has been rejected.',
                'job_id' => $application->job->id,
                'application_id' => $application->id,
            ]
        ));

        return back()->with('success', 'Application rejected.');
    }

    /**
     * Employer views applicants for a job
     */
    public function jobApplicants(Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $applications = $job->applications()->with('user')->paginate(10);

        return view('employer.applicants', compact('job', 'applications'));
    }
}