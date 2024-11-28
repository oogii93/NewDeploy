@extends('admin.dashboard')

@section('admin')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.past-examples.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">



                        </div>



                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-bold  text-center mt-3 mb-3">タイトル</label>
                            <input type="text" name="title" id="title" class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2  dark:bg-gray-700 dark:text-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <textarea id="summernote" name="description"></textarea>
                        </div>




                        {{-- <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-3 rounded-r h-10 w-28">投稿</button> --}}
                        <div class="flex justify-between">
                            <x-button purpose="default" type="" href="{{ url('/admin/past-examples/') }}">
                                戻る
                            </x-button>
                            <x-button purpose="search" type="submit">
                                追加
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
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        $editable.find('iframe').each(function() {
                            if (!$(this).parent().hasClass('responsive-video-container')) {
                                $(this).wrap('<div class="responsive-video-container"></div>');
                            }
                        });
                    }
                }
            });
        });

        $('form').submit(function() {
            var content = $('#summernote').summernote('code');
            content = content.replace(/<iframe/g, '<div class="responsive-video-container"><iframe');
            content = content.replace(/<\/iframe>/g, '</iframe></div>');
            $('#summernote').val(content);
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
@endsection
