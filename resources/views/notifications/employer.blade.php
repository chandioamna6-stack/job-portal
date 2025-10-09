@extends('layouts.app')

@section('content')
<h1>Employer Notifications</h1>
<ul>
    @foreach($notifications as $notification)
        <li>
            {{ $notification->data['message'] ?? $notification->type }}
            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit">Mark as Read</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection