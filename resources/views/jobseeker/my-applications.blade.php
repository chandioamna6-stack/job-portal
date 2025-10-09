@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📄 My Applications</h2>

    @if($applications->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">You have not applied to any jobs yet.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resume</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($applications as $application)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                {{ $application->job->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                {{ $application->job->company }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($application->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">⏳ Pending</span>
                                @elseif($application->status === 'accepted')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">✅ Accepted</span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">❌ Rejected</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Other</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ asset('storage/' . $application->resume) }}" target="_blank"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    📑 View Resume
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $application->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $applications->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
