

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-6 rounded-t-xl">
                    <h1 class="text-3xl font-extrabold text-white tracking-tight">
                        過去実例編集

                    </h1>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 bg-white">
                    <form action="{{ route('past-examples.update', $pastExample->id) }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        @method('PUT') <!-- Specify the HTTP method as PATCH -->

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-bold text-center mt-3 mb-3">タイトル</label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title', $pastExample->title) }}"
                                class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2 dark:bg-gray-700 dark:text-gray-300"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="past_examples_category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                カテゴリ
                            </label>
                            <select
                                name="past_examples_category_id"
                                id="past_examples_category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                                required
                            >
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $pastExample->past_examples_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <textarea id="summernote" name="description">
                                {{ old('description', $pastExample->description) }}
                            </textarea>
                        </div>

                        <div class="flex justify-between">
                            <x-button purpose="default" href="{{ url('/past-examples/') }}">
                                戻る
                            </x-button>
                            <x-button purpose="search" type="submit">
                                更新
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Include jQuery and Summernote JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <style>
        .responsive-video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }
        .responsive-video-container iframe,
        .responsive-video-container object,
        .responsive-video-container embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>

</x-app-layout>

