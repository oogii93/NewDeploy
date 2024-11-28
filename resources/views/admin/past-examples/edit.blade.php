@extends('admin.dashboard')

@section('admin')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <h1 class="text-2xl font-bold mb-6">Past Example Edit</h1>

        <form action="{{ route('admin.past-examples.update', $pastExample->id) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $pastExample->title ?? '') }}"
                       class="form-select mt-1 block w-full sm:w-2/3 md:w-1/2 lg:w-1/3 border border-black focus:ring-opacity-80"
                       style="border-width: 1px;"
                       required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea name="description" id="description"
                          class="form-select mt-1 block w-full sm:w-2/3 md:w-1/2 lg:w-1/3 border border-black focus:ring-opacity-80"
                          style="border-width: 1px;"
                          required>{{ old('description', $pastExample->description ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="images" class="block text-gray-700 text-sm font-bold mb-2">Images:</label>
                <input type="file" name="images[]" id="images" multiple
                       accept="image/*"
                       class="form-select mt-1 block w-full sm:w-2/3 md:w-1/2 lg:w-1/3 border border-black focus:ring-opacity-80"
                       style="border-width: 1px;">
            </div>

            @if($pastExample->images)
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Images:</label>
                    <div class="flex space-x-2">
                        @foreach($pastExample->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Current Image" class="w-24 h-24 object-cover">
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-between">
                <x-button purpose="default" type="" href="{{ route('admin.past-examples.index') }}">
                    Back
                </x-button>
                <x-button purpose="search" type="submit">
                    Update
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection
