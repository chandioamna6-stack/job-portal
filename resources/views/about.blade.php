@extends('layouts.app')

@section('title', 'About Us | Job Portal')

@section('content')
<section class="relative bg-gradient-to-br from-blue-50 to-blue-100 py-20">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl font-extrabold text-blue-800 mb-6">About Job Portal</h1>
        <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
            Welcome to <span class="font-semibold text-blue-700">Job Portal</span> — your trusted bridge between 
            exceptional talent and leading employers. We are dedicated to simplifying the recruitment journey 
            through innovation, efficiency, and connection.
        </p>
    </div>

    <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/dots.png')] opacity-10"></div>
</section>

<section class="py-20">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div class="order-2 md:order-1">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80" 
                 alt="Team working together" 
                 class="rounded-2xl shadow-2xl transform hover:scale-105 transition duration-500">
        </div>

        <div class="order-1 md:order-2">
            <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-6">Our Mission</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">
                Our mission is to empower job seekers to find meaningful opportunities and enable employers 
                to attract top talent seamlessly. We prioritize creating a trusted ecosystem that promotes 
                transparency, growth, and career advancement.
            </p>

            <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">Our Vision</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">
                We envision a world where recruitment is no longer a challenge but an exciting journey 
                toward mutual success — driven by technology, authenticity, and purpose.
            </p>
        </div>
    </div>
</section>

<section class="bg-blue-50 py-20">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">Meet the Developer</h2>
            <p class="text-gray-700 mb-4 leading-relaxed">
                Hi, I'm <span class="font-semibold text-blue-700">Amna</span> — a passionate Full-Stack Developer 
                at <span class="font-semibold">iCreativez</span>. I love building scalable, user-focused web 
                applications using <span class="font-medium">Laravel</span>, <span class="font-medium">Vue.js</span>, 
                and <span class="font-medium">Tailwind CSS</span>.
            </p>
            <p class="text-gray-700 leading-relaxed">
                My goal is to craft digital experiences that are not only functional but also delightful to use — 
                turning complex problems into elegant solutions.
            </p>
        </div>
        <div class="text-center">
            <img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=800&q=80" 
                 alt="Developer workspace" 
                 class="rounded-2xl shadow-2xl mx-auto transform hover:scale-105 transition duration-500">
        </div>
    </div>
</section>
@endsection
