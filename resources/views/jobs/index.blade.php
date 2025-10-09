@extends('layouts.app')

@section('title', 'Job Listings')

@section('content')
<div class="container mx-auto px-4 py-10">
    
    <h1 class="text-3xl font-bold mb-6">Job Listings</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search & Filters --}}
    <form method="GET" action="{{ route('jobs.index') }}" class="mb-6 grid md:grid-cols-6 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..." class="border rounded-lg px-3 py-2 w-full">
        <input type="text" name="location" value="{{ request('location') }}" placeholder="Location" class="border rounded-lg px-3 py-2 w-full">
        <select name="employment_type" class="border rounded-lg px-3 py-2 w-full">
            <option value="">All Types</option>
            <option value="Full-time" {{ request('employment_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
            <option value="Part-time" {{ request('employment_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
            <option value="Contract" {{ request('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
            <option value="Internship" {{ request('employment_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
        </select>
        <input type="number" name="salary_min" value="{{ request('salary_min') }}" placeholder="Min Salary" class="border rounded-lg px-3 py-2 w-full">
        <input type="number" name="salary_max" value="{{ request('salary_max') }}" placeholder="Max Salary" class="border rounded-lg px-3 py-2 w-full">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition md:col-span-6">
            Filter
        </button>
    </form>

    {{-- Job Listings --}}
    @if($jobs->count())
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($jobs as $job)
            <div class="border rounded-lg p-6 shadow hover:shadow-2xl transition bg-white relative
                        {{ $job->is_premium ? 'border-yellow-400 ring-2 ring-yellow-300' : '' }}">

                {{-- Premium Badge --}}
                @if($job->is_premium)
                    <span class="absolute top-2 right-2 bg-yellow-400 text-white px-3 py-1 text-xs font-bold rounded-full shadow-lg">
                        Premium
                    </span>
                @endif

                <div class="flex items-center gap-4 mb-4">
                    {{-- Company Logo Placeholder --}}
                    <div class="h-12 w-12 bg-gray-200 flex items-center justify-center rounded-full text-gray-600 font-bold">
                        {{ strtoupper(substr($job->company, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
                        <span class="text-gray-500 text-sm">{{ $job->company }}</span>
                    </div>
                </div>

                <div class="text-sm text-gray-600 space-y-1">
                    <div><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</div>
                    <div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                            {{ $job->employment_type }}
                        </span>
                    </div>
                    <div><i class="fas fa-graduation-cap"></i> Skills: {{ implode(', ', $job->skills ?? []) }}</div>
                </div>

                <div class="mt-4 flex flex-col md:flex-row justify-between items-center gap-2">
                    <div class="font-semibold text-blue-600">
                        ${{ $job->salary_min ?? 'N/A' }} - ${{ $job->salary_max ?? 'N/A' }}
                    </div>

                    {{-- Buttons for Job Seekers --}}
                    @if(auth()->check() && auth()->user()->role === 'job_seeker')
                        <div class="flex flex-wrap gap-2">
                            {{-- View / Apply --}}
                            <a href="{{ route('jobs.show', $job->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow hover:shadow-lg">
                                View & Apply
                            </a>

                            {{-- Save / Unsave --}}
                            @if(auth()->user()->savedJobs->contains($job->id))
                                <form action="{{ route('jobseeker.jobs.unsave', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition shadow hover:shadow-lg">
                                        Unsave
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('jobseeker.jobs.save', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition shadow hover:shadow-lg">
                                        Save Job
                                    </button>
                                </form>
                            @endif

                            {{-- Message Employer --}}
                            <a href="{{ route('messages.show', $job->user_id) }}?job_id={{ $job->id }}" 
                               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow hover:shadow-lg">
                                Message Employer
                            </a>
                        </div>

                    {{-- Employer's own jobs --}}
                    @elseif(auth()->check() && auth()->user()->role === 'employer' && auth()->id() === $job->user_id)
                        <div class="flex flex-col md:flex-row items-center gap-2">
                            {{-- Status --}}
                            <span class="px-2 py-1 text-xs font-semibold rounded 
                                {{ $job->status === 'approved' ? 'bg-green-100 text-green-800' : ($job->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($job->status) }}
                            </span>

                            {{-- Delete Button --}}
                            <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition shadow hover:shadow-lg">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $jobs->withQueryString()->links() }}
        </div>
    @else
        <p>No jobs found.</p>
    @endif
</div>
@endsection