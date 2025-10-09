@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container mx-auto px-4 py-10">

    {{-- Premium Job Highlight --}}
    @if($job->is_premium)
        <div class="mb-4 px-4 py-2 rounded bg-yellow-100 text-yellow-800 font-semibold text-center shadow-lg animate-pulse">
            ⭐ Premium Job Listing ⭐
        </div>
    @endif

    {{-- Job Logo --}}
    @if($job->logo)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }} Logo" class="h-24 w-auto object-contain">
        </div>
    @endif

    {{-- Job Header --}}
    <h1 class="text-3xl font-bold mb-2">{{ $job->title }}</h1>
    <p class="text-lg text-gray-700 mb-1"><strong>Company:</strong> {{ $job->company }}</p>
    <p class="text-lg text-gray-700 mb-1"><strong>Location:</strong> {{ $job->location }}</p>
    <p class="text-lg text-gray-700 mb-4"><strong>Type:</strong> {{ $job->employment_type }}</p>

    {{-- Skills --}}
    @if(!empty($job->skills))
        <div class="mb-4 flex flex-wrap gap-2">
            @foreach($job->skills as $skill)
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm font-medium">{{ $skill }}</span>
            @endforeach
        </div>
    @endif

    {{-- Description --}}
    <div class="bg-white shadow p-6 rounded-lg mb-6">
        <h2 class="text-xl font-semibold mb-2">Job Description</h2>
        <p class="text-gray-600 whitespace-pre-line">{{ $job->description }}</p>
    </div>

    {{-- Apply Form --}}
    @if(auth()->check() && auth()->user()->role === 'job_seeker')
        <div class="bg-white shadow p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Apply for this job</h2>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jobseeker.applications.store', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="resume" class="block text-sm font-medium text-gray-700">Upload Resume</label>
                    <input type="file" name="resume" id="resume" class="mt-1 block w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter (optional)</label>
                    <textarea name="cover_letter" id="cover_letter" rows="4" class="mt-1 block w-full border rounded-lg p-2"></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow hover:shadow-lg">
                    Submit Application
                </button>
            </form>
        </div>
    @else
        <p class="mt-6 text-gray-500">⚠ You must be logged in as a <strong>Job Seeker</strong> to apply.</p>
    @endif
</div>
@endsection