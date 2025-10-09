@extends('layouts.app')

@section('title', 'Contact Us | Job Portal')

@section('content')
<section class="relative bg-gradient-to-br from-blue-50 to-blue-100 py-20">
    <div class="container mx-auto px-6 text-center relative z-10">
        <h1 class="text-5xl font-extrabold text-blue-800 mb-4">Get in Touch</h1>
        <p class="text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
            Whether you’re a job seeker, employer, or partner — we’d love to hear from you.  
            Reach out and we’ll get back to you as soon as possible.
        </p>
    </div>
    <div class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/dots.png')] opacity-10"></div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <!-- Contact Info -->
        <div class="space-y-8">
            <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-6">Contact Information</h2>
            <p class="text-gray-700 leading-relaxed mb-6">
                We’re here to answer your questions, support your hiring goals, or help you start your career journey.
            </p>

            <div class="space-y-4 text-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <a href="mailto:support@jobportal.com" class="text-lg hover:text-blue-600 transition">
                        support@jobportal.com
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-phone-alt text-xl"></i>
                    </div>
                    <p class="text-lg">+1 (555) 123-4567</p>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <p class="text-lg">123 Tech Street, Silicon City, USA</p>
                </div>
            </div>

            <a href="{{ route('about') }}" 
               class="inline-block mt-8 bg-blue-600 text-white px-8 py-3 rounded-xl shadow-lg hover:bg-blue-700 transition">
               Learn More About Us
            </a>
        </div>

        <!-- Contact Form -->
        <div class="bg-blue-50 rounded-2xl shadow-2xl p-8 md:p-10">
            <h3 class="text-2xl font-bold text-blue-700 mb-6 text-center">Send Us a Message</h3>
            <form action="#" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Full Name</label>
                    <input type="text" name="name" placeholder="Your name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Email</label>
                    <input type="email" name="email" placeholder="you@example.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Message</label>
                    <textarea name="message" rows="4" placeholder="Write your message..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none"></textarea>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
