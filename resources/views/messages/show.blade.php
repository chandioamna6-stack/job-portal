@extends('layouts.app')

@section('content')
<div class="container mx-auto h-[85vh] bg-white shadow rounded-lg flex flex-col">

    {{-- Chat Header --}}
    <div class="flex items-center p-4 border-b bg-blue-600 text-white sticky top-0 z-10">
        {{-- Back button --}}
        <a href="{{ route('messages.index') }}" class="mr-3 text-white text-xl hover:text-gray-200">
            <i class="fas fa-arrow-left"></i>
        </a>

        {{-- Avatar --}}
        <div class="w-10 h-10 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold mr-3">
            {{ strtoupper(substr($receiver->name, 0, 1)) }}
        </div>

        {{-- User Info --}}
        <div>
            <h2 class="text-lg font-semibold">{{ $receiver->name }}</h2>
            <p class="text-xs opacity-80">Online</p>
        </div>
    </div>

    {{-- Messages Area --}}
    <div id="chat-box" class="flex-1 p-4 overflow-y-auto bg-gray-100 space-y-3">
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-md px-4 py-2 rounded-2xl shadow 
                    {{ $msg->sender_id == auth()->id() 
                        ? 'bg-blue-500 text-white rounded-br-none' 
                        : 'bg-white text-gray-800 rounded-bl-none border' }}">
                    
                    {{-- Sender name --}}
                    <p class="text-xs font-semibold mb-1 opacity-70">
                        {{ $msg->sender_id == auth()->id() ? 'You' : $receiver->name }}
                    </p>

                    {{-- Message --}}
                    <p class="break-words">{{ $msg->message }}</p>

                    {{-- Timestamp --}}
                    <span class="block text-[11px] mt-1 opacity-70 text-right">
                        {{ $msg->created_at->format('M d, H:i') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Input Box --}}
    <form action="{{ route('messages.store') }}" method="POST" class="flex items-center p-3 border-t bg-white">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

        <input type="text" name="message" placeholder="Type a message..."
               class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">

        <button type="submit"
                class="ml-3 px-5 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 flex items-center justify-center transition">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>
</div>

{{-- Auto scroll to bottom --}}
@push('scripts')
<script>
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endpush
@endsection