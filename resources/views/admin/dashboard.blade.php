@extends('layouts.app')

@section('title', 'Job Portal')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    
<!-- ==========================
     LEFT SIDEBAR / NAV BAR
========================== -->
<aside class="fixed inset-y-0 left-0 w-64 bg-blue-200 text-gray-800 shadow-md flex flex-col">
    <!-- Profile Section -->
    <div class="p-6 flex flex-col items-center border-b border-blue-300">
        <!-- Admin Profile Photo with glow effect on hover -->
        <img class="w-20 h-20 rounded-full mb-4 border-2 border-yellow-400 object-cover transition-transform duration-300 ease-in-out
                    hover:scale-110 hover:shadow-[0_0_15px_rgba(0,255,0,0.7)]"
             src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('default-avatar.png') }}"
             alt="{{ auth()->user()->name }}">
        <!-- Admin Name (Uppercase & Green) -->
        <h2 class="text-2xl font-bold text-green-600 mb-1 uppercase text-center">{{ auth()->user()->name }}</h2>
        <!-- Admin Role -->
        <p class="text-gray-600 mb-6 font-medium uppercase text-sm text-center">{{ auth()->user()->role }}</p>
    </div>

    <!-- Sidebar Links / Navigation -->
    <nav class="mt-4 flex-1 px-2 space-y-2">
        <a href="{{ route('home') }}"
           class="block py-3 px-4 rounded text-blue-800 font-medium transition transform duration-300 ease-in-out
                  hover:bg-blue-300 hover:scale-105 hover:shadow-[0_0_10px_rgba(0,0,0,0.2)]">
            Home
        </a>
        <a href="{{ route('admin.jobs.index') }}"
   class="block py-3 px-4 rounded text-green-700 font-medium transition transform duration-300 ease-in-out
          hover:bg-green-200 hover:scale-105 hover:shadow-[0_0_10px_rgba(0,0,0,0.2)]">
    Manage Jobs
</a>

<a href="{{ route('admin.payments.index') }}"
   class="block py-3 px-4 rounded text-yellow-700 font-medium transition transform duration-300 ease-in-out
          hover:bg-yellow-200 hover:scale-105 hover:shadow-[0_0_10px_rgba(0,0,0,0.2)]">
    Payments
</a>

<a href="{{ route('admin.dashboard') }}"
   class="block py-3 px-4 rounded text-purple-700 font-medium transition transform duration-300 ease-in-out
          hover:bg-purple-200 hover:scale-105 hover:shadow-[0_0_10px_rgba(0,0,0,0.2)]">
    Job Portal
</a>
        <a href="{{ route('profile.edit') }}"
           class="block py-3 px-4 rounded text-pink-700 font-medium transition transform duration-300 ease-in-out
                  hover:bg-pink-200 hover:scale-105 hover:shadow-[0_0_10px_rgba(0,0,0,0.2)]">
            My Profile
        </a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="block py-3 px-4 rounded text-red-600 font-medium transition transform duration-300 ease-in-out
                  hover:bg-red-200 hover:text-red-800 hover:scale-105 hover:shadow-[0_0_10px_rgba(0,0,0,0.2)]">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

    </nav>
</aside>
    <!-- ==========================
         MAIN CONTENT AREA
         ========================== -->
    <div class="flex-1 ml-64 flex flex-col">


        <!-- ==========================
             TOP NAV BAR
             ========================== -->
        <!-- ==========================
     TOP NAV BAR
     ========================== -->
<header class="bg-white shadow-md p-4 flex justify-between items-center border-b border-gray-200">
    <h1 class="text-2xl font-bold text-purple-700">Job Portal</h1>

    <!-- Admin Notification Bell -->
    <div class="relative">
        <a href="{{ route('admin.notifications.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 01-3.46 0"></path>
            </svg>
        </a>
        @php
    $adminNotificationsCount = auth()->user()->unreadNotifications->count();
@endphp
        @if($adminNotificationsCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                {{ $adminNotificationsCount }}
            </span>
        @endif
    </div>
</header>

       <!-- ==========================
     DASHBOARD CONTENT
========================== -->
<main class="p-6 space-y-6">

    <!-- Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-yellow-50 p-6 rounded-lg shadow hover:shadow-lg hover:scale-105 transition transform text-center">
            <p class="text-sm text-yellow-700 font-semibold">Total Jobs</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ \App\Models\Job::count() }}</h2>
        </div>
        <div class="bg-green-50 p-6 rounded-lg shadow hover:shadow-lg hover:scale-105 transition transform text-center">
            <p class="text-sm text-green-700 font-semibold">Total Applications</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\Application::count() }}</h2>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg hover:scale-105 transition transform text-center">
            <p class="text-sm text-blue-700 font-semibold">Total Employers</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\User::where('role','employer')->count() }}</h2>
        </div>
        <div class="bg-red-50 p-6 rounded-lg shadow hover:shadow-lg hover:scale-105 transition transform text-center">
            <p class="text-sm text-red-700 font-semibold">Total Job Seekers</p>
            <h2 class="text-3xl font-bold text-red-500 mt-2">{{ \App\Models\User::where('role','job_seeker')->count() }}</h2>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center w-full max-w-md hover:shadow-lg transition transform hover:scale-105">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 text-center">Jobs by Status</h3>
            <div class="w-full h-64">
                <canvas id="jobsChart" class="w-full h-full"></canvas>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center w-full max-w-md hover:shadow-lg transition transform hover:scale-105">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 text-center">Applications by Status</h3>
            <div class="w-full h-64">
                <canvas id="applicationsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Jobs Table -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto hover:shadow-lg transition transform hover:scale-105">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Jobs</h3>
        <table class="min-w-full table-auto border-collapse text-left">
            <thead>
                <tr class="bg-purple-50 text-purple-700">
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Company</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Posted On</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Job::latest()->take(10)->get() as $job)
                    <tr class="border-b hover:bg-purple-50 transition">
                        <td class="px-4 py-2 border">{{ $job->title }}</td>
                        <td class="px-4 py-2 border">{{ $job->company }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $job->status }}</td>
                        <td class="px-4 py-2 border">{{ $job->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Applications Table -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto hover:shadow-lg transition transform hover:scale-105">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Applications</h3>
        <table class="min-w-full table-auto border-collapse text-left">
            <thead>
                <tr class="bg-green-50 text-green-700">
                    <th class="px-4 py-2 border">Job Title</th>
                    <th class="px-4 py-2 border">Applicant</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Applied On</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Application::with('user','job')->latest()->take(10)->get() as $app)
                    <tr class="border-b hover:bg-green-50 transition">
                        <td class="px-4 py-2 border">{{ $app->job->title }}</td>
                        <td class="px-4 py-2 border">{{ $app->user->name }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $app->status }}</td>
                        <td class="px-4 py-2 border">{{ $app->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const jobsData = {
    labels: ['Pending', 'Approved', 'Rejected'],
    datasets: [{
        label: 'Jobs by Status',
        data: [
            {{ \App\Models\Job::where('status','pending')->count() }},
            {{ \App\Models\Job::where('status','approved')->count() }},
            {{ \App\Models\Job::where('status','rejected')->count() }},
        ],
        backgroundColor: ['#facc15', '#34d399', '#f87171']
    }]
};

const applicationsData = {
    labels: ['Pending', 'Accepted', 'Rejected'],
    datasets: [{
        label: 'Applications by Status',
        data: [
            {{ \App\Models\Application::where('status','pending')->count() }},
            {{ \App\Models\Application::where('status','accepted')->count() }},
            {{ \App\Models\Application::where('status','rejected')->count() }},
        ],
        backgroundColor: ['#facc15', '#34d399', '#f87171']
    }]
};

new Chart(document.getElementById('jobsChart'), {
    type: 'doughnut',
    data: jobsData,
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});

new Chart(document.getElementById('applicationsChart'), {
    type: 'doughnut',
    data: applicationsData,
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endsection $adminNot