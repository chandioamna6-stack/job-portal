@extends('layouts.app')

@section('title', 'Admin — Job Details')

@section('content')
<div class="container mx-auto px-4 py-10">
    {{-- Back button --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Job Details</h1>
        <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Back to Jobs</a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <div class="px-6 py-6">

            {{-- Job header --}}
            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $job->title }}
                        @if($job->is_premium)
                            <span class="ml-2 px-2 py-1 text-xs font-semibold text-white bg-purple-600 rounded-full">Premium</span>
                        @endif
                    </h2>
                    <p class="text-gray-500 text-sm">{{ $job->company }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-2">
                    @if($job->status === 'approved')
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">Approved</span>
                    @elseif($job->status === 'pending')
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-sm">Pending</span>
                    @elseif($job->status === 'rejected')
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-sm">Rejected</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-semibold text-sm">{{ ucfirst($job->status) }}</span>
                    @endif
                </div>
            </div>

            {{-- Job info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-gray-700"><span class="font-semibold">Location:</span> {{ $job->location }}</p>
                    <p class="text-gray-700 mt-1"><span class="font-semibold">Employment Type:</span> {{ $job->employment_type }}</p>
                    <p class="text-gray-700 mt-1"><span class="font-semibold">Salary:</span> {{ $job->salary_min ?? '-' }} - {{ $job->salary_max ?? '-' }}</p>
                    <p class="text-gray-700 mt-1"><span class="font-semibold">Skills:</span> {{ implode(', ', $job->skills ?? []) }}</p>
                </div>
                <div>
                    <p class="text-gray-700"><span class="font-semibold">Posted By:</span> {{ $job->employer->name ?? '-' }}</p>
                    <p class="text-gray-700 mt-1"><span class="font-semibold">Email:</span> {{ $job->employer->email ?? '-' }}</p>
                    <p class="text-gray-700 mt-1"><span class="font-semibold">Featured:</span> {{ $job->is_featured ? 'Yes' : 'No' }}</p>
                    <p class="text-gray-700 mt-1"><span class="font-semibold">Posted On:</span> {{ $job->created_at->format('F j, Y, g:i a') }}</p>
                </div>
            </div>

            {{-- Job description --}}
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Job Description</h3>
                <div class="text-gray-600 text-sm leading-relaxed p-4 bg-gray-50 rounded-lg border border-gray-200">
                    {{ $job->description }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection