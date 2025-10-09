<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    /**
     * Display the employer dashboard with their jobs and applicants count.
     */
    public function index()
    {
        // Ensure only employers access this
        if (!Auth::user()->hasRole('employer')) {
            abort(403, 'Unauthorized.');
        }

        // Get jobs posted by the logged-in employer
        $jobs = Job::where('user_id', Auth::id())
                    ->withCount('applications') // Count of applicants for each job
                    ->latest()
                    ->paginate(10);

        return view('employer.dashboard', compact('jobs'));
    }

    /**
     * Show a specific job with its applicants
     */
    public function show(Job $job)
    {
        // Ensure this job belongs to the logged-in employer
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        // Get paginated applicants for this job with user info
        $applicants = $job->applications()->with('user')->paginate(10);

        return view('employer.applicants', compact('job', 'applicants'));
    }
}
