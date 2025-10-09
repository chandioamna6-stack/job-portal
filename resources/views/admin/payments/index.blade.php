@extends('layouts.app')

@section('title', 'Payments Management')

@section('content')
<div class="container mx-auto px-6 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Payments Management</h1>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 shadow">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 shadow">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Employer</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Job</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Transaction ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Screenshot</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Notes</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Submitted At</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $payment->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $payment->user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $payment->job->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">${{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $payment->transaction_id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            @if($payment->screenshot)
                                <a href="{{ asset('storage/' . $payment->screenshot) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                    View
                                </a>
                            @else
                                <span class="text-gray-400 italic">No file</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $payment->notes ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($payment->status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($payment->status === 'approved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Approved
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            @if($payment->status === 'pending')
                                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition shadow" type="submit">Approve</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition shadow" type="submit">Reject</button>
                                </form>
                            @else
                                <span class="text-gray-400 italic">No actions</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-gray-400 italic">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endsection