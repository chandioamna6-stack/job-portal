<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class JobController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $totalJobs = Job::count();
        $totalPending = Job::where('status', 'pending')->count();
        $totalApproved = Job::where('status', 'approved')->count();
        $totalRejected = Job::where('status', 'rejected')->count();
        $totalPremium = Job::where('is_premium', true)->count();

        $recentJobs = Job::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalJobs', 'totalPending', 'totalApproved', 'totalRejected', 'totalPremium', 'recentJobs'
        ));
    }

    /**
     * Show all jobs (pending, approved, rejected)
     */
    public function index()
    {
        $jobs = Job::latest()->paginate(10);
        return view('admin.jobs', compact('jobs'));
    }

    /**
     * Show a single job details (Admin view)
     */
    public function show(Job $job)
    {
        return view('admin.job-show', compact('job'));
    }

    /**
     * Approve a job and notify the employer
     */
    public function approve(Job $job)
    {
        // Keep premium flag as is, only update status
        $job->update([
            'status' => 'approved',
        ]);

        // Notify the employer
        $employer = $job->user; // Make sure Job model has 'user' relationship
        if ($employer) {
            $message = "Your job '{$job->title}' has been approved by admin.";
            if ($job->is_premium) {
                $message .= " (Premium job)";
            }
            NotificationFacade::send($employer, new SystemNotification(
                'Job Approved',
                [
                    'message' => $message,
                    'job_id' => $job->id,
                    'is_premium' => $job->is_premium,
                ]
            ));
        }

        return redirect()->back()->with('success', 'Job approved successfully.');
    }

    /**
     * Reject a job and notify the employer
     */
    public function reject(Job $job)
    {
        $job->update(['status' => 'rejected']);

        // Notify the employer
        $employer = $job->user;
        if ($employer) {
            $message = "Your job '{$job->title}' has been rejected by admin.";
            if ($job->is_premium) {
                $message .= " (Premium job)";
            }
            NotificationFacade::send($employer, new SystemNotification(
                'Job Rejected',
                [
                    'message' => $message,
                    'job_id' => $job->id,
                    'is_premium' => $job->is_premium,
                ]
            ));
        }

        return redirect()->back()->with('success', 'Job rejected successfully.');
    }
}