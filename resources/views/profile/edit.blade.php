@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="profile-page-bg min-h-screen py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Profile Card --}}
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
            <div class="md:flex">

                {{-- Left Column: Avatar / Info --}}
                <div class="md:w-1/3 p-8 text-center bg-gray-50 dark:bg-gray-900">
                    <img
    class="mx-auto rounded-full h-28 w-28 object-cover"
    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://i.imgur.com/0eg0aG0.jpg' }}"
    onerror="this.src='https://i.imgur.com/0eg0aG0.jpg';"
    alt="{{ $user->name }}">


                    <div class="mt-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        {{ $user->name }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($user->role) }}</div>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $user->country ?? 'Not set' }}</div>
                </div>

                {{-- Right Column: Forms --}}
                <div class="md:w-2/3 p-6">
                    
                    {{-- Back to Dashboard --}}
               @php
    $dashboardRoute = match(auth()->user()->role) {
        'admin' => route('admin.dashboard'),
        'employer' => route('employer.dashboard'),
        'job_seeker' => route('jobseeker.dashboard'),
        default => route('home'),
    };
@endphp

<a href="{{ $dashboardRoute }}" class="inline-block px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
    ⬅ Back to Dashboard
</a>



                    {{-- Additional Info Form --}}
                    <div class="p-4 bg-white dark:bg-gray-800 border rounded-lg shadow-sm mb-6">
                        <h3 class="text-md font-medium text-gray-700 dark:text-gray-200 mb-3">Additional Info</h3>
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                    <input type="text" name="country" value="{{ old('country', $user->country) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                                    <input type="text" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Number</label>
                                    <input type="text" name="account_number" value="{{ old('account_number', $user->account_number) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Picture</label>
                                    <input type="file" name="avatar" class="mt-1 block w-full text-sm text-gray-500">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/'.$user->avatar) }}" class="mt-2 h-16 w-16 rounded-full object-cover">
                                    @endif
                                </div>

                            </div>

                            <div class="mt-4 text-right">
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Account Info Form (Name/Email) --}}
                    <div class="p-4 bg-white dark:bg-gray-800 border rounded-lg shadow-sm mb-6">
                        <h3 class="text-md font-medium text-gray-700 dark:text-gray-200 mb-3">Account Info</h3>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Change Password --}}
                    <div class="p-4 bg-white dark:bg-gray-800 border rounded-lg shadow-sm mb-6">
                        <h3 class="text-md font-medium text-gray-700 dark:text-gray-200 mb-3">Change Password</h3>
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Danger Zone --}}
                    <div class="p-4 bg-white dark:bg-gray-800 border rounded-lg shadow-sm mb-6">
                        <h3 class="text-md font-medium text-gray-700 dark:text-gray-200 mb-3">Danger Zone</h3>
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-page-bg { background: #F3E8FF; }
</style>
@endsection
