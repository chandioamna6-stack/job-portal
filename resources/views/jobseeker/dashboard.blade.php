@extends('layouts.app')

@section('title', 'Job Seeker Dashboard')

@section('content')
<div class="container mx-auto px-4 py-10">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100">
        Job Seeker Dashboard
    </h1>

    <!-- Profile Card -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 flex items-center hover:shadow-xl transition backdrop-blur-sm bg-opacity-90">
        <!-- Avatar -->
        <div class="relative">
            <img class="h-20 w-20 rounded-full object-cover border-4 border-purple-500 shadow-md"
                 src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : auth()->user()->profile_photo_url ?? 'https://i.imgur.com/0eg0aG0.jpg' }}"
                 alt="{{ auth()->user()->name }}">
            <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
        </div>

        <!-- Info -->
        <div class="ml-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 capitalize">
                {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}
            </p>
        </div>

        <!-- Profile Button -->
        <div class="ml-auto">
            <a href="{{ route('profile.edit') }}"
               class="px-5 py-2 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 shadow-md hover:shadow-purple-400/50 transition">
                My Profile
            </a>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="mt-10">
        <p class="text-gray-700 dark:text-gray-300 text-lg">
            Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>!  
            Here you can manage your applications, profile, and chat with employers.
        </p>
    </div>

    <!-- Action Cards -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Saved Jobs Card -->
        <div class="p-6 bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-lg hover:shadow-blue-400/40 transition backdrop-blur-sm flex flex-col items-center text-center">
            <div class="text-blue-600 dark:text-blue-400 text-4xl mb-3">
                <i class="fas fa-bookmark"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Saved Jobs</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Quickly access your bookmarked opportunities.</p>
            <a href="{{ route('jobseeker.saved-jobs') }}"
               class="mt-4 inline-block px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md hover:shadow-blue-400/50 transition">
                View
            </a>
        </div>

        <!-- Applications Card -->
        <div class="p-6 bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-lg hover:shadow-green-400/40 transition backdrop-blur-sm flex flex-col items-center text-center">
            <div class="text-green-600 dark:text-green-400 text-4xl mb-3">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Applications</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Track the status of your job applications here.</p>
            <a href="{{ route('jobseeker.applications.my') }}"
               class="mt-4 inline-block px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md hover:shadow-green-400/50 transition">
                Track
            </a>
        </div>

        <!-- Messages Card -->
        <div class="p-6 bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-lg hover:shadow-indigo-400/40 transition backdrop-blur-sm flex flex-col items-center text-center">
            <div class="text-indigo-600 dark:text-indigo-400 text-4xl mb-3">
                <i class="fas fa-comments"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Messages</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Stay in touch with employers via chat.</p>
            <a href="{{ route('messages.index') }}"
               class="mt-4 inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md hover:shadow-indigo-400/50 transition">
                Open
            </a>
        </div>

    </div>

</div>
@endsection