<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\JobAppliedNotification;

class JobController extends Controller
{
    // --------------------------- Job Seeker Methods ---------------------------

    public function index(Request $request)
    {
        $query = Job::where('status', 'approved'); // Only show admin-approved jobs

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereJsonContains('skills', $search);
            });
        }

        if ($request->filled('location')) $query->where('location', 'like', '%' . $request->input('location') . '%');
        if ($request->filled('employment_type')) $query->where('employment_type', $request->input('employment_type'));
        if ($request->filled('salary_min')) $query->where('salary_min', '>=', $request->input('salary_min'));
        if ($request->filled('salary_max')) $query->where('salary_max', '<=', $request->input('salary_max'));

        $jobs = $query->latest()->paginate(10)->withQueryString();
        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function savedJobs()
    {
        $user = auth()->user();
        $savedJobs = $user->savedJobs()->latest()->paginate(10);
        return view('jobseeker.saved-jobs', compact('savedJobs'));
    }

    public function apply(Request $request, Job $job)
    {
        if (Auth::user()->role !== 'job_seeker') abort(403, 'Employers cannot apply for jobs.');

        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
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

        $employer = $job->user;
        if ($employer) {
            $employer->notify(new JobAppliedNotification($application));
        }

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }

    public function saveJob(Job $job)
    {
        $user = Auth::user();
        if ($user->role !== 'job_seeker') abort(403, 'Only job seekers can save jobs.');
        $user->savedJobs()->syncWithoutDetaching([$job->id]);
        return back()->with('success', 'Job saved successfully!');
    }

    public function unsaveJob(Job $job)
    {
        $user = Auth::user();
        if ($user->role !== 'job_seeker') abort(403, 'Only job seekers can unsave jobs.');
        $user->savedJobs()->detach($job->id);
        return back()->with('success', 'Job removed from saved list.');
    }

    public function myApplications()
    {
        $applications = Auth::user()
                            ->applications()
                            ->with('job')
                            ->latest()
                            ->paginate(10);
        return view('jobseeker.my-applications', compact('applications'));
    }

    // --------------------------- Employer Methods ---------------------------

    public function employerDashboard()
    {
        $jobs = Job::where('user_id', Auth::id())
                   ->withCount('applications')
                   ->latest()
                   ->paginate(10);
        return view('employer.dashboard', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_min' => 'nullable|integer|min:0|max:2000000000',
            'salary_max' => 'nullable|integer|min:0|max:2000000000|gte:salary_min',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'description' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'is_premium' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('job-logos', 'public') : null;

        $job = Job::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title'] . '-' . Str::random(5)),
            'company' => $validated['company'],
            'location' => $validated['location'],
            'employment_type' => $validated['employment_type'],
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'skills' => $validated['skills'] ?? [],
            'description' => $validated['description'],
            'is_featured' => $validated['is_featured'] ?? false,
            'is_premium' => false, // premium only after payment proof approved
            'premium_expires_at' => null,
            'logo' => $logoPath,
            'status' => 'pending',
        ]);

        // Redirect to manual payment proof if premium requested
        if (!empty($validated['is_premium'])) {
            return redirect()->route('employer.payments.create', $job->id)
                             ->with('info', 'Please submit payment proof to activate premium.');
        }

        return redirect()->route('jobs.index')
                         ->with('success', 'Job posted successfully! Awaiting admin approval.');
    }

    public function update(Request $request, Job $job)
    {
        if ($job->user_id !== Auth::id() || Auth::user()->role !== 'employer') abort(403, 'Unauthorized action.');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'salary_min' => 'nullable|integer|min:0|max:2000000000',
            'salary_max' => 'nullable|integer|min:0|max:2000000000|gte:salary_min',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'description' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'is_premium' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($job->logo && Storage::disk('public')->exists($job->logo)) {
                Storage::disk('public')->delete($job->logo);
            }
            $validated['logo'] = $request->file('logo')->store('job-logos', 'public');
        }

        $job->update($validated);

        // Redirect to manual payment proof if premium selected and not already premium
        if (!empty($validated['is_premium']) && !$job->is_premium) {
            return redirect()->route('employer.payments.create', $job->id)
                             ->with('info', 'Please submit payment proof to activate premium.');
        }

        return redirect()->route('employer.dashboard')
                         ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        if ($job->user_id !== Auth::id() || Auth::user()->role !== 'employer') abort(403, 'Unauthorized action.');
        $job->delete();
        return redirect()->back()->with('success', 'Job deleted successfully.');
    }

    public function applicants(Job $job)
    {
        if ($job->user_id !== Auth::id()) abort(403, 'Unauthorized action.');
        $applicants = $job->applications()->with('user')->paginate(10);
        return view('employer.applicants', compact('job', 'applicants'));
    }

    public function acceptApplication(Application $application)
    {
        if ($application->job->user_id !== Auth::id()) abort(403, 'Unauthorized action.');
        $application->update(['status' => 'accepted']);
        return back()->with('success', 'Application accepted successfully.');
    }

    public function rejectApplication(Application $application)
    {
        if ($application->job->user_id !== Auth::id()) abort(403, 'Unauthorized action.');
        $application->update(['status' => 'rejected']);
        return back()->with('success', 'Application rejected successfully.');
    }
}