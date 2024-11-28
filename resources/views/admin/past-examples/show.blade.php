<x-app-layout>

<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <h1 class="text-2xl font-bold mb-6 text-center mt-5">{{ $pastExample->title }}</h1>



        <div class="mb-4">

            <div id="summernote">{!! $pastExample->description !!}</div>
        </div>

        <div class="flex justify-between">
            <x-button purpose="default" type="" href="{{ url('/ComputerForm/ ') }}">
              戻り
            </x-button>
        </div>
    </div>
</div>

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
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
                onImageUpload: function(files) {
                    var formData = new FormData();
                    formData.append('image', files[0]);

                    $.ajax({
                        url: "{{ route('admin.past-examples.upload-image') }}",
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                $('#summernote').summernote('insertImage', response.url);
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            },
            disableResizeEditor: true,
            disableDragAndDrop: true
        });
    });
    </script>
@endsection

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

