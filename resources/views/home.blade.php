@extends('layouts.app')

@section('title', 'Job Portal | Homepage')

@section('content')
{{-- ================= Hero Section ================= --}}
<section class="bg-gradient-to-r from-blue-50 to-blue-100 py-20" 
         style="background-image: url('https://learn.g2crowd.com/hubfs/fullsizeoutput_4d.jpeg'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-4 text-center bg-black bg-opacity-50 py-16 rounded-lg">
        <h1 class="text-4xl font-bold text-white">Discover Your Perfect Career Match</h1>
        <p class="mt-4 text-lg text-gray-200">Join thousands of professionals finding their dream jobs at top companies worldwide</p>

        {{-- Search Bar --}}
        <div class="mt-8 flex flex-wrap gap-3 justify-center">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" class="pl-10 pr-4 py-2 border rounded-lg w-80 focus:ring-2 focus:ring-blue-400" placeholder="Job title, keywords, or company">
            </div>
            <div>
                <select class="border rounded-lg py-2 px-3 w-56 focus:ring-2 focus:ring-blue-400">
                    <option>All Locations</option>
                    <option>New York</option>
                    <option>London</option>
                    <option>Tokyo</option>
                    <option>Berlin</option>
                </select>
            </div>
            <div>
                <select class="border rounded-lg py-2 px-3 w-56 focus:ring-2 focus:ring-blue-400">
                    <option>All Categories</option>
                    <option>Technology</option>
                    <option>Finance</option>
                    <option>Healthcare</option>
                    <option>Education</option>
                    <option>Marketing</option>
                </select>
            </div>
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition">
                <i class="fas fa-search"></i> Search
            </button>
        </div>

        {{-- ================= Dashboard / Auth Buttons ================= --}}
        <div class="mt-6 flex justify-center gap-4">
            @auth
                {{-- Dashboard Button --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Dashboard
                    </a>
                @elseif(auth()->user()->role === 'employer')
                    <a href="{{ route('employer.dashboard') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Dashboard
                    </a>
                @elseif(auth()->user()->role === 'job_seeker')
                    <a href="{{ route('jobseeker.dashboard') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Dashboard
                    </a>
                @endif

                {{-- Find Jobs / Browse Jobs --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.jobs.index') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-briefcase"></i> Browse Jobs
                    </a>
                @else
                    <a href="{{ route('jobs.index') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-briefcase"></i> Find Jobs
                    </a>
                @endif

                {{-- Post a Job Button (only for employer) --}}
                @if(auth()->user()->role === 'employer')
                    <a href="{{ route('employer.jobs.create') }}" 
                       class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-plus"></i> Post a Job
                    </a>
                @endif

            @else
                {{-- Guest users --}}
                <a href="{{ route('jobs.index') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-briefcase"></i> Find Jobs
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-plus"></i> Post a Job
                </a>
            @endauth
        </div>
    </div>
</section>

{{-- ================= Featured Jobs Section ================= --}}
<section id="jobs" class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold">Featured Opportunities</h2>
            <p class="text-gray-600">Browse through our most recent job openings from innovative companies</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Job Card --}}
            <div class="border rounded-lg p-6 shadow hover:shadow-lg transition job-card">
                <h3 class="text-xl font-semibold">Senior Frontend Developer</h3>
                <span class="text-gray-500">TechCorp</span>
                <div class="mt-3 space-y-1 text-sm text-gray-600">
                    <div><i class="fas fa-map-marker-alt"></i> California, USA</div>
                    <div><i class="fas fa-briefcase"></i> Full-time</div>
                    <div><i class="fas fa-graduation-cap"></i> Master's</div>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="font-semibold text-blue-600">$120,000 - $150,000</div>
                    <a href="@auth 
                                @if(auth()->user()->role === 'admin')
                                    {{ route('admin.jobs.index') }}
                                @else
                                    {{ route('jobs.index') }}
                                @endif
                            @else
                                {{ route('login') }}
                            @endauth" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Apply Now
                    </a>
                </div>
            </div>

            <div class="border rounded-lg p-6 shadow hover:shadow-lg transition job-card">
                <h3 class="text-xl font-semibold">Product Designer</h3>
                <span class="text-gray-500">Designify</span>
                <div class="mt-3 space-y-1 text-sm text-gray-600">
                    <div><i class="fas fa-map-marker-alt"></i> Remote</div>
                    <div><i class="fas fa-briefcase"></i> Full-time</div>
                    <div><i class="fas fa-graduation-cap"></i> Bachelor's</div>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="font-semibold text-blue-600">$90,000 - $120,000</div>
                    <a href="@auth 
                                @if(auth()->user()->role === 'admin')
                                    {{ route('admin.jobs.index') }}
                                @else
                                    {{ route('jobs.index') }}
                                @endif
                            @else
                                {{ route('login') }}
                            @endauth" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Apply Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= Companies Section ================= --}}
@include('partials.companies') {{-- Include the companies slider --}}
@endsection
