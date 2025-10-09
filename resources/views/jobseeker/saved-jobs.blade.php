@extends('layouts.app')

@section('title', 'Saved Jobs')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6">Saved Jobs</h1>

    @if($savedJobs->count())
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($savedJobs as $job)
                <div class="border rounded-lg p-6 shadow hover:shadow-lg transition job-card">
                    <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
                    <span class="text-gray-500">{{ $job->company }}</span>
                    <div class="mt-3 space-y-1 text-sm text-gray-600">
                        <div><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</div>
                        <div><i class="fas fa-briefcase"></i> {{ ucfirst($job->type) }}</div>
                        <div><i class="fas fa-graduation-cap"></i> {{ $job->education }}</div>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <div class="font-semibold text-blue-600">${{ $job->salary_min }} - ${{ $job->salary_max }}</div>
                        <a href="{{ route('jobs.show', $job->id) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            View Job
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $savedJobs->links() }}
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow text-gray-700">
            You haven’t saved any jobs yet.
        </div>
    @endif
</div>
@endsection
