@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
<div class="container mx-auto px-4 py-10">

    {{-- Page Heading --}}
    <h1 class="text-3xl font-extrabold mb-8 text-gray-800 tracking-tight">
        Employer Dashboard
    </h1>

    {{-- Profile Card --}}
    <div class="flex items-center bg-white/80 backdrop-blur-md shadow-lg rounded-2xl p-6 mb-10 border border-gray-200 transition hover:shadow-xl hover:scale-[1.01] duration-300">
        {{-- Avatar --}}
        <img class="h-20 w-20 rounded-full object-cover mr-5 shadow-md ring-2 ring-purple-500 hover:scale-110 transition duration-300"
             src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : auth()->user()->profile_photo_url ?? 'https://i.imgur.com/0eg0aG0.jpg' }}"
             alt="{{ auth()->user()->name }}">

        {{-- User Info --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-gray-600 capitalize">
                Employer
            </p>
        </div>

        {{-- Profile & Messages Buttons --}}
        <div class="ml-auto flex space-x-3">
            <a href="{{ route('profile.edit') }}"
               class="px-5 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 hover:shadow-lg transition-all">
                My Profile
            </a>
            <a href="{{ route('messages.index') }}"
               class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 hover:shadow-lg transition-all">
                Messages
            </a>
        </div>
    </div>

    {{-- Welcome Message --}}
    <p class="text-lg text-gray-700 mb-6">
        👋 Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>!  
        Here are the jobs you’ve posted:
    </p>

    {{-- Employer Jobs Table --}}
    @if($jobs->count())
        <div class="overflow-x-auto rounded-2xl shadow-lg bg-white/70 backdrop-blur-md mt-6 border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Applicants</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white/50 divide-y divide-gray-200">
                    @foreach($jobs as $job)
                        <tr class="hover:bg-indigo-50 transition-all duration-200 ease-in-out">
                            {{-- Job Title + Logo --}}
                            <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-4">
                                @if($job->logo)
                                    <img src="{{ asset('storage/' . $job->logo) }}" 
                                         alt="Logo" 
                                         class="h-12 w-12 object-cover rounded-full shadow-md">
                                @else
                                    <div class="h-12 w-12 bg-gradient-to-r from-purple-400 to-indigo-500 flex items-center justify-center rounded-full text-white font-bold shadow-md">
                                        {{ strtoupper(substr($job->company, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $job->title }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($job->description, 60) }}</div>
                                </div>
                            </td>

                            {{-- Company --}}
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $job->company }}</td>

                            {{-- Location --}}
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $job->location }}</td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($job->status === 'approved')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-700 shadow-sm">
                                        Approved
                                    </span>
                                @elseif($job->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 shadow-sm">
                                        Pending
                                    </span>
                                @elseif($job->status === 'rejected')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-700 shadow-sm">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-700 shadow-sm">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Applicants --}}
                            <td class="px-6 py-4 text-right text-sm text-gray-800 font-semibold">
                                {{ $job->applications_count ?? 0 }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right flex justify-end space-x-2">
                                <a href="{{ route('employer.jobs.show', $job->id) }}" 
                                   class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 hover:shadow-md transition-all">
                                   View
                                </a>
                                <a href="{{ route('messages.index') }}?job_id={{ $job->id }}" 
                                   class="px-3 py-1.5 text-sm bg-green-500 text-white rounded-lg shadow hover:bg-green-600 hover:shadow-md transition-all">
                                   Chat
                                </a>
                                <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-lg shadow hover:bg-red-600 hover:shadow-md transition-all">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            <div class="inline-flex space-x-2">
                {{ $jobs->links() }}
            </div>
        </div>
    @else
        <div class="bg-white/80 backdrop-blur-md p-6 rounded-xl shadow-md text-gray-600 mt-6 text-center">
            🚀 You haven’t posted any jobs yet. Start by creating your first one!
        </div>
    @endif

</div>
@endsection