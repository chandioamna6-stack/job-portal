@extends('layouts.app')

@section('title', 'Admin — Manage Jobs')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6">Manage Job Posts</h1>

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

    @if($jobs->count())
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($jobs as $job)
                        <tr id="job-{{ $job->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $job->title }}
                                    @if($job->is_premium)
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold text-white bg-purple-600 rounded-full">Premium</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">{{ Str::limit($job->description, 80) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $job->company }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ optional($job->user)->name ?? '—' }}
                                <div class="text-xs text-gray-400">{{ optional($job->user)->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $job->location }}</td>
                            <td class="px-6 py-4">
                                @if($job->status === 'approved')
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                @elseif($job->status === 'pending')
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($job->status === 'rejected')
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                @else
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($job->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($job->is_premium)
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Premium</span>
                                @else
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex justify-end gap-2 flex-wrap">
                                    <a href="{{ route('admin.jobs.show', $job->id) }}" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                        View
                                    </a>

                                    @if($job->status !== 'approved')
                                        <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($job->status !== 'rejected')
                                        <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                                Reject
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow text-gray-700">
            No job posts found.
        </div>
    @endif
</div>
@endsection