@php
    $role = strtolower(trim(auth()->user()->role ?? ''));
    $notifications = auth()->check() ? auth()->user()->notifications()->latest()->take(5)->get() : collect();
    $unreadCount = $notifications->where('read_at', null)->count();
@endphp

{{-- Hide header only on admin dashboard --}}
@if(!($role === 'admin' && request()->routeIs('admin.dashboard')))
<header class="bg-white shadow sticky top-0 z-50" x-data="{ open: false, notifOpen: false }">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">Job Portal</a>

        {{-- Nav Links (Desktop) --}}
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
            <a href="{{ route('jobs.index') }}" class="hover:text-blue-600 transition">Browse Jobs</a>
           
            <a href="{{ route('about') }}" class="hover:text-blue-600 transition">About</a>
            <a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Contact</a>

            @auth
                @if($role === 'employer')
                    <a href="{{ route('employer.jobs.create') }}" class="hover:text-blue-600 transition">Post a Job</a>
                @elseif($role === 'job_seeker' || $role === 'jobseeker')
                    <a href="{{ url('/jobseeker/saved-jobs') }}" class="hover:text-blue-600 transition">Saved Jobs</a>
                @elseif($role === 'admin')
                    <a href="{{ url('/admin/jobs') }}" class="hover:text-blue-600 transition">Manage Jobs</a>
                @endif
            @endauth
        </nav>

        {{-- Auth Buttons + Notifications --}}
        <div class="hidden md:flex items-center gap-4 relative">
            @auth
                @php
                    $dashboardUrl = match($role) {
                        'admin' => url('/admin/dashboard'),
                        'employer' => url('/employer/dashboard'),
                        'job_seeker', 'jobseeker' => url('/jobseeker/dashboard'),
                        default => url('/home'),
                    };
                @endphp

                {{-- Notifications --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">
                        <i class="fas fa-bell text-gray-700 text-lg"></i>
                        @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    {{-- Notifications Dropdown --}}
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200 z-50">
                        <div class="p-4 text-gray-700 font-semibold border-b border-gray-200">
                            Notifications
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            @forelse($notifications as $notif)
                                <a href="{{ $notif->link ?? '#' }}" class="block px-4 py-2 text-sm hover:bg-gray-100 {{ is_null($notif->read_at) ? 'bg-gray-50 font-medium' : '' }}">
                                    {{ $notif->message }}
                                    <span class="block text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                                </a>
                            @empty
                                <div class="px-4 py-2 text-sm text-gray-500">
                                    No notifications.
                                </div>
                            @endforelse
                        </div>
                        <div class="border-t border-gray-200 text-center">
                            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-50">
                                View All
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Dashboard --}}
                <a href="{{ $dashboardUrl }}" 
                   class="w-32 h-10 flex items-center justify-center bg-blue-600 text-white font-semibold hover:bg-blue-700 transition rounded">
                    Dashboard
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-32 h-10 flex items-center justify-center border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition rounded">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-32 h-10 flex items-center justify-center border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition rounded">
                    Login
                </a>
                <a href="{{ route('register') }}" class="w-32 h-10 flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 transition rounded">
                    Register
                </a>
            @endauth
        </div>

        {{-- Mobile Hamburger --}}
        <button class="md:hidden flex items-center justify-center w-8 h-8 relative z-50" @click="open = !open">
            <div :class="open ? 'opacity-0' : 'opacity-100'" class="flex flex-col gap-1 transition-opacity">
                <span class="w-6 h-0.5 bg-black"></span>
                <span class="w-6 h-0.5 bg-black"></span>
                <span class="w-6 h-0.5 bg-black"></span>
            </div>
            <svg :class="open ? 'opacity-100 rotate-90' : 'opacity-0'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm md:hidden transition-opacity"
         x-show="open" x-transition.opacity @click="open = false"></div>

    {{-- Mobile Menu --}}
    <div class="fixed top-0 right-0 h-full w-3/4 max-w-sm bg-white shadow-lg transform transition-transform md:hidden"
         x-bind:class="open ? 'translate-x-0' : 'translate-x-full'">
        <div class="flex flex-col gap-4 px-6 py-8">
            <a href="{{ route('home') }}" class="block py-2 hover:text-blue-600">Home</a>
            <a href="{{ route('jobs.index') }}" class="block py-2 hover:text-blue-600">Browse Jobs</a>
            <a href="{{ route('companies') }}" class="block py-2 hover:text-blue-600">Companies</a>

            <a href="{{ route('about') }}" class="block py-2 hover:text-blue-600">About</a>
            <a href="{{ route('contact') }}" class="block py-2 hover:text-blue-600">Contact</a>
        </div>
    </div>
</header>
@endif 