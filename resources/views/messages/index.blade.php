@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Messages</h1>

    @if($conversations->isEmpty())
        <p class="text-gray-500">No conversations yet.</p>
    @else
        <ul class="space-y-2">
            @foreach($conversations->unique('sender_id')->unique('receiver_id') as $conv)
                @php
                    $otherUser = $conv->sender_id == auth()->id() ? $conv->receiver : $conv->sender;
                @endphp
                <li>
                    <a href="{{ route('messages.show', $otherUser->id) }}"
                       class="block p-4 bg-white rounded-lg shadow hover:bg-blue-100 transition flex justify-between items-center">
                        <span>{{ $otherUser->name }}</span>
                        @if($conv->is_read == false && $conv->receiver_id == auth()->id())
                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">New</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection