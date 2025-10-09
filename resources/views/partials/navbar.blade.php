@php
    function isActiveRoute($routeName) {
        return request()->routeIs($routeName) ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600';
    }

    $role = strtolower(trim(auth()->user()->role ?? 'guest'));
@endphp

{{-- Only show nav for non-admin users --}}
@if($role !== 'admin')
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">JobPortal</a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden sm:flex sm:space-x-8 items-center">
                <a href="{{ route('home') }}" class="{{ isActiveRoute('home') }}">Home</a>
                <a href="{{ route('jobs.index') }}" class="{{ isActiveRoute('jobs.index') }}">Browse Jobs</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Companies</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">About</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Contact</a>

                @auth
                    @if($role === 'job_seeker')
                        <a href="{{ route('jobseeker.saved-jobs') }}" class="{{ isActiveRoute('jobseeker.saved-jobs') }}">Saved Jobs</a>
                    @elseif($role === 'employer')
                        <a href="{{ route('jobs.create') }}" class="{{ isActiveRoute('jobs.create') }}">Post a Job</a>
                    @endif
                @endauth
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth
                    @php
                        $dashboardUrl = match($role) {
                            'employer' => route('employer.dashboard'),
                            'job_seeker' => route('jobseeker.dashboard'),
                            default => route('home'),
                        };
                    @endphp

                    <a href="{{ $dashboardUrl }}" class="{{ isActiveRoute($dashboardUrl) }}">Dashboard</a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Register</a>
                @endauth
            </div>

            {{-- Mobile Hamburger --}}
            <div class="flex items-center sm:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="sm:hidden hidden px-4 pt-2 pb-4 space-y-1 bg-white shadow-md">
        <a href="{{ route('home') }}" class="{{ isActiveRoute('home') }} block">Home</a>
        <a href="{{ route('jobs.index') }}" class="{{ isActiveRoute('jobs.index') }} block">Browse Jobs</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">Companies</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">About</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">Contact</a>

        @auth
            @if($role === 'job_seeker')
                <a href="{{ route('jobseeker.saved-jobs') }}" class="block {{ isActiveRoute('jobseeker.saved-jobs') }}">Saved Jobs</a>
            @elseif($role === 'employer')
                <a href="{{ route('jobs.create') }}" class="block {{ isActiveRoute('jobs.create') }}">Post a Job</a>
            @endif

            @php
                $dashboardUrl = match($role) {
                    'employer' => route('employer.dashboard'),
                    'job_seeker' => route('jobseeker.dashboard'),
                    default => route('home'),
                };
            @endphp
            <a href="{{ $dashboardUrl }}" class="block bg-blue-600 text-white px-4 py-2 rounded-md mt-2">Dashboard</a>

            <form method="POST" action="{{ route('logout') }}" class="block mt-2">
                @csrf
                <button type="submit" class="w-full text-left text-gray-700 hover:text-red-600">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block text-gray-700 hover:text-blue-600">Login</a>
            <a href="{{ route('register') }}" class="block bg-blue-600 text-white px-4 py-2 rounded-md">Register</a>
        @endauth
    </div>

    {{-- Mobile Menu Toggle Script --}}
    <script>
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</nav>
@endif
