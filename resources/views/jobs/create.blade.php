@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6">Post a Job</h1>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Job Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="border rounded-lg px-3 py-2 w-full">
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold">Company Name</label>
            <input type="text" name="company" value="{{ old('company') }}" class="border rounded-lg px-3 py-2 w-full">
            @error('company')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold">Company Logo</label>
            <input type="file" name="logo" accept="image/*" class="border rounded-lg px-3 py-2 w-full">
            <small class="text-gray-500">Upload PNG, JPG or JPEG (Max: 2MB)</small>
            @error('logo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold">Location</label>
            <input type="text" name="location" value="{{ old('location') }}" class="border rounded-lg px-3 py-2 w-full">
            @error('location')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold">Employment Type</label>
            <select name="employment_type" class="border rounded-lg px-3 py-2 w-full">
                <option value="Full-time" {{ old('employment_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                <option value="Part-time" {{ old('employment_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                <option value="Internship" {{ old('employment_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
            </select>
            @error('employment_type')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Salary Min</label>
                <input type="number" name="salary_min" value="{{ old('salary_min') }}" class="border rounded-lg px-3 py-2 w-full">
                @error('salary_min')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-semibold">Salary Max</label>
                <input type="number" name="salary_max" value="{{ old('salary_max') }}" class="border rounded-lg px-3 py-2 w-full">
                @error('salary_max')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div id="skills-container">
            <label class="block font-semibold">Skills</label>
            <input type="text" name="skills[]" class="border rounded-lg px-3 py-2 w-full mb-2" placeholder="e.g. PHP, Laravel">
            @error('skills.*')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="button" onclick="addSkill()" class="bg-gray-500 text-white px-3 py-1 rounded hover:shadow-lg transition">+ Add Skill</button>

        <div>
            <label class="block font-semibold">Job Description</label>
            <textarea name="description" rows="6" class="border rounded-lg px-3 py-2 w-full">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Featured and Premium Checkboxes --}}
        <div class="flex space-x-4 mt-2">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="mr-2"> Featured Job
            </label>

            <label class="inline-flex items-center">
                <input type="checkbox" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }} class="mr-2"> Premium Job
                <span class="ml-2 text-gray-500 text-sm">⚡ Mark as premium and submit payment proof after creation</span>
            </label>
        </div>

        <div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition shadow-lg hover:shadow-xl">
                Post Job
            </button>
        </div>
    </form>
</div>

<script>
    function addSkill() {
        let container = document.getElementById('skills-container');
        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'skills[]';
        input.className = 'border rounded-lg px-3 py-2 w-full mb-2';
        input.placeholder = "e.g. Vue.js, Tailwind";
        container.appendChild(input);
    }
</script>
@endsection