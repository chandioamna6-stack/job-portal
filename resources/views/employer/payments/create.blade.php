@extends('layouts.app')

@section('title', 'Submit Payment Proof')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Submit Payment Proof</h1>

    {{-- Instruction / Account Info --}}
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded shadow-sm">
        <p class="font-semibold text-blue-700 mb-1">Please send your payment to the following account:</p>
        <p class="text-gray-800 font-mono text-lg">{{ $dummyAccount ?? 'ACC-FQNI0NET' }}</p>
        <p class="text-gray-600 mt-1 text-sm">After payment, upload your proof below.</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4 shadow-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.payments.store', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf

        {{-- Transaction ID --}}
        <div>
            <label class="block font-semibold mb-1">Transaction ID / Reference</label>
            <input type="text" name="transaction_id" required 
                   class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Screenshot / Proof --}}
        <div>
            <label class="block font-semibold mb-1">Upload Payment Proof</label>
            <input type="file" name="screenshot" accept="image/*,.pdf" 
                   class="border rounded-lg px-3 py-2 w-full">
            <small class="text-gray-500">Accepted formats: JPG, PNG, PDF (Max: 2MB)</small>
        </div>

        {{-- Additional Notes --}}
        <div>
            <label class="block font-semibold mb-1">Additional Notes (optional)</label>
            <textarea name="notes" rows="4" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
        </div>

        {{-- Submit Button --}}
        <div class="text-center">
            <button type="submit" 
                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition shadow-lg hover:shadow-xl">
                Submit Proof
            </button>
        </div>
    </form>
</div>
@endsection