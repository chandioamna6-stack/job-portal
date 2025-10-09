@extends('layouts.app')

@section('title', 'Companies')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Top Companies Hiring</h2>
        <p class="text-gray-600 mb-8">Explore the companies that are actively hiring today.</p>

        {{-- You can reuse your company logos section here --}}
        @include('partials.companies-section')
    </div>
</section>
@endsection
