@extends('layouts.app')

@section('title', 'Applicants')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Applicants for: <span class="text-indigo-600">{{ $job->title }}</span>
    </h2>

    @if($applicants->isEmpty())
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
            No applicants yet for this job.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Resume</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Cover Letter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Applied On</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($applicants as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $application->user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $application->user->email }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $application->resume) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center px-3 py-1 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    View Resume
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if($application->cover_letter)
                                    <button onclick="document.getElementById('modal-{{ $application->id }}').showModal()" 
                                            class="inline-flex items-center px-3 py-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        View
                                    </button>

                                    <!-- Modal -->
                                    <dialog id="modal-{{ $application->id }}" class="rounded-lg p-6 shadow-xl max-w-2xl">
                                        <h3 class="text-lg font-semibold mb-4">Cover Letter - {{ $application->user->name }}</h3>
                                        <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                                        <div class="mt-4 text-right">
                                            <button onclick="document.getElementById('modal-{{ $application->id }}').close()" 
                                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                                                Close
                                            </button>
                                        </div>
                                    </dialog>
                                @else
                                    <span class="text-gray-400 italic">No cover letter</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($application->status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                @elseif($application->status === 'accepted')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Accepted</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $application->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3">
                                    @if($application->status === 'pending')
                                        <form action="{{ route('employer.applications.accept', $application->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('employer.applications.reject', $application->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Message Button --}}
                                    <a href="{{ route('messages.show', $application->user->id) }}?job_id={{ $job->id }}"
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                                        </svg>
                                        Message
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $applicants->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection