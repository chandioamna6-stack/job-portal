<?php

use App\Http\Controllers\Employer\EmployerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/companies', function () {
    return view('companies');
})->name('companies');


// =================== Public Routes ===================

// Homepage
Route::get('/', function () {
    return view('home'); 
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// =================== Role-Based Dashboard Redirect ===================
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'employer') {
        return redirect()->route('employer.dashboard');
    } elseif ($user->role === 'job_seeker') {
        return redirect()->route('jobseeker.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    abort(403, 'Unauthorized');
})->middleware(['auth', 'verified'])->name('dashboard');

// =================== Admin Routes ===================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/dashboard', [AdminJobController::class, 'dashboard'])->name('dashboard');

    Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');
    Route::patch('/jobs/{job}/approve', [AdminJobController::class, 'approve'])->name('jobs.approve');
    Route::patch('/jobs/{job}/reject', [AdminJobController::class, 'reject'])->name('jobs.reject');

    // ✅ Add payment management routes here
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{payment}/approve', [\App\Http\Controllers\PaymentController::class, 'approve'])->name('payments.approve');
    Route::patch('/payments/{payment}/reject', [\App\Http\Controllers\PaymentController::class, 'reject'])->name('payments.reject');
});
// =================== Employer Routes ===================
Route::middleware(['auth', 'verified'])->prefix('employer')->name('employer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('dashboard');

    // Job creation (must come BEFORE {job} route)
    Route::get('/jobs/create', [JobController::class, 'create'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.create');

    Route::post('/jobs', [JobController::class, 'store'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.store');

    // Edit job form
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.edit');

    // Update job
    Route::put('/jobs/{job}', [JobController::class, 'update'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.update');

    // View single job
    Route::get('/jobs/{job}', [EmployerDashboardController::class, 'show'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.show');

    // View applicants for a job
    Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'jobApplicants'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.applicants');

    // Update applicant status
    Route::patch('/applications/{application}/accept', [ApplicationController::class, 'accept'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('applications.accept');

    Route::patch('/applications/{application}/reject', [ApplicationController::class, 'reject'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('applications.reject');

    // Delete a job
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
        ->middleware(RoleMiddleware::class.':employer')
        ->name('jobs.destroy');

// =================== Manual Premium Payment Proof Routes ===================
    Route::get('/jobs/{job}/payment-proof', [\App\Http\Controllers\PaymentController::class, 'create'])
        ->name('payments.create');
    Route::post('/jobs/{job}/payment-proof', [\App\Http\Controllers\PaymentController::class, 'store'])
        ->name('payments.store');
});

// =================== Job Seeker Routes ===================
Route::middleware(['auth', 'verified'])->prefix('jobseeker')->name('jobseeker.')->group(function () {

    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'job_seeker') abort(403);
        return view('jobseeker.dashboard');
    })->name('dashboard');

    // Saved jobs
    Route::get('/saved-jobs', [JobController::class, 'savedJobs'])->name('saved-jobs');
    Route::post('/jobs/{job}/save', [JobController::class, 'saveJob'])->name('jobs.save');
    Route::delete('/jobs/{job}/unsave', [JobController::class, 'unsaveJob'])->name('jobs.unsave');

    // Applications
    Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('applications.store');
    Route::get('/applications', [JobController::class, 'myApplications'])->name('applications.my');
});

// =================== Jobs Routes ===================
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// =================== Profile Routes ===================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =================== Messaging Routes ===================
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessagesController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{user}/read', [MessagesController::class, 'markAsRead'])->name('messages.read');
});

// =================== Notifications Routes ===================
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// =================== Auth Scaffolding ===================
require __DIR__.'/auth.php';