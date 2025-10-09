@extends('layouts.app')

@section('title', $job->title . ' - Job Details')

@section('content')
<div class="container mx-auto px-4 py-10">

    {{-- Back button --}}
    <a href="{{ route('employer.dashboard') }}"
       class="inline-block mb-4 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
        &larr; Back to Dashboard
    </a>

    {{-- Job Details Card --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-2">{{ $job->title }}</h1>
        <p class="text-gray-700 mb-1"><strong>Company:</strong> {{ $job->company }}</p>
        <p class="text-gray-700 mb-1"><strong>Location:</strong> {{ $job->location }}</p>
        <p class="text-gray-700 mb-1"><strong>Employment Type:</strong> {{ $job->employment_type }}</p>
        @if($job->salary_min || $job->salary_max)
            <p class="text-gray-700 mb-1"><strong>Salary:</strong> 
                ${{ $job->salary_min ?? 'N/A' }} - ${{ $job->salary_max ?? 'N/A' }}
            </p>
        @endif
        @if($job->skills && count($job->skills))
            <p class="text-gray-700 mb-1"><strong>Skills:</strong> 
                {{ implode(', ', $job->skills) }}
            </p>
        @endif

        <hr class="my-4">

        <h2 class="text-xl font-semibold mb-2">Job Description</h2>
        <p class="text-gray-700">{{ $job->description }}</p>

        <hr class="my-4">

        {{-- Job Status --}}
        <p class="mb-2">
            <strong>Status:</strong>
            @if($job->status === 'approved')
                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
            @elseif($job->status === 'pending')
                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
            @elseif($job->status === 'rejected')
                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
            @else
                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($job->status) }}</span>
            @endif

            @if($job->is_premium)
                <span class="ml-2 px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Premium until {{ \Carbon\Carbon::parse($job->premium_expires_at)->format('M d, Y') }}
                </span>
            @endif
        </p>

        {{-- Applicants Count & Link --}}
        <p class="mt-4">
            <strong>Applicants:</strong> {{ $job->applications_count ?? 0 }}
            <a href="{{ route('employer.jobs.applicants', $job->id) }}"
               class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                View Applicants
            </a>
        </p>

        {{-- PayPal Premium Button --}}
        @if($job->status === 'approved' && !$job->is_premium)
            <div class="mt-6">
                <a href="{{ route('employer.paypal.create', $job->id) }}"
                   class="px-6 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
                    Upgrade to Premium (Pay $10)
                </a>
            </div>
        @endif

    </div>
</div>
@endsection