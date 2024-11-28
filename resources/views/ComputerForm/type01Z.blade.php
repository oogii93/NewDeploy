
<x-app-layout>

    <div class="mt-5 mb-5 flex justify-center">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="w-full max-w-4xl bg-white shadow-lg rounded-xl p-6">
        <form action="{{ route('forms2', '01Z') }}" method="POST" class=" overflow-hidden" enctype="multipart/form-data">
            @csrf

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">問い合わせ</h1>
                <p class="text-gray-500 mt-2">事件に関する詳細な情報を提供してください</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2">
                        会社
                    </label>
                    <input
                    readonly
                        id="corp"
                        name="corp"
                        value="{{ Auth::user()->corp->corp_name ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >


                    </input>
                </div>
                <div>
                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2">
                        営業所
                    </label>
                    <input
                    readonly
                        id="office"
                        name="office"
                        value="{{ Auth::user()->office->office_name ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >


                    </input>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        名前
                    </label>
                    <input

                         readonly
                        type="text"
                        id="name"
                        name="name"
                        value="{{ Auth::user()->name ?? '' }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="Enter your full name"
                    >
                </div>

                <div>
                    <label for="occurrence_date" class="block text-sm font-medium text-gray-700 mb-2">
                        発生日時
                    </label>
                    <input
                        type="datetime-local"
                        id="occured_date"
                        name="occured_date"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                </div>

                <div class="col-span-full">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        状況、頻度の説明
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="発生頻度を含め、インシデントの詳細な説明を提供する"
                    ></textarea>
                </div>

                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">
                        回答期限
                    </label>
                    <select
                        id="answer"
                        name="answer"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                        <option value="">選択</option>
                        <option value="優先度">優先度</option>
                        <option value="緊急度">緊急度</option>

                    </select>
                </div>

                <div class="col-span-full">
                    <label for="screen_copy" class="block text-sm font-medium text-gray-700 mb-2">
                        画面コピー (スクリーンショット)
                    </label>

                    <div
                    id="drop-zone"
                    class="w-full p-6 border-2 border-dashed border-gray-300 rounded-lg text-center transition-all duration-300 hover:border-blue-500 hover:bg-blue-50"
                >
                    <input
                        type="file"
                        id="screen_copy"
                      name="screen_copy[]"
                        accept="image/*"
                        multiple
                        class="hidden"
                    >

                    <div  id="drop-zone-text" class="text-gray-500">
                        <p>ファイルをドラッグ＆ドロップ、コピー＆ペースト</label></p>
                        <p class="text-xs mt-2">PNG、JPG、GIF (最大5MB)</p>

                    </div>
                    <div id="preview-container" class="mt-4 grid grid-cols-3 gap-4 "></div>
                </div>

                <div class="col-span-full">
                    <label for="self_attempt" class="block text-sm font-medium text-gray-700 mb-2">
                        自己対応で試したこと
                    </label>
                    <textarea
                        id="self_attempt"
                        name="self_attempt"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="問題を解決するためにすでに実行した手順を説明します"
                    ></textarea>
                </div>
            </div>

            <div class="text-center mt-8 ">
                <button
                    type="submit"
                    class="flex justify-start px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300"
                >
                  申請する
                </button>
            </div>
        </form>
    </div>

    <script>
        // Optional: Add client-side validations or interactions
        document.querySelector('form').addEventListener('submit', function(e) {
            // Example: Basic validation
            const requiredFields = this.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    e.preventDefault();
                    field.classList.add('border-red-500');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('screen_copy');
            const dropZoneText = document.getElementById('drop-zone-text');
            const previewContainer = document.getElementById('preview-container');


            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop zone when item is dragged over
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            // Handle dropped files
            dropZone.addEventListener('drop', handleDrop, false);

            // Handle file input change
            fileInput.addEventListener('change', handleFiles, false);

            document.addEventListener('paste', handlePaste, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight() {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            function handlePaste(e) {
        const items = e.clipboardData.items;
        const pastedFiles = [];




        for (let i = 0; i < items.length; i++) {
            if (items[i].type.indexOf("image") !== -1) {
                const blob = items[i].getAsFile();
                pastedFiles.push(blob);
            }
        }

        if (pastedFiles.length > 0) {
        // Get existing files from input
        const existingFiles = Array.from(fileInput.files);

        // Combine existing and new files, avoiding duplicates
        const combinedFiles = [...new Set([...existingFiles, ...pastedFiles])];

        // Limit to 5 files
        const limitedFiles = combinedFiles.slice(0, 5);

        // Create a new DataTransfer to set combined files
        const dataTransfer = new DataTransfer();
        limitedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;

        // Refresh previews
        previewContainer.innerHTML = ''; // Clear existing previews
        handleFiles(limitedFiles);
    }
    }


            function handleFiles(files) {
                files = files instanceof FileList ? Array.from(files) : files;

                // Limit to 5 files
                const fileList = Array.from(files).slice(0, 5);

                previewContainer.innerHTML = '';

                fileList.forEach(file => {
                    // Check file type and size
                    if (file.type.startsWith('image/') && file.size <= 5 * 1024 * 1024) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const previewWrapper = document.createElement('div');
                            previewWrapper.className = 'relative';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-full h-32 object-cover rounded-lg';

                            const removeBtn = document.createElement('button');
                            removeBtn.innerHTML = '✖';
                            removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs';
                            removeBtn.onclick = function() {
                                previewWrapper.remove();
                            };

                            previewWrapper.appendChild(img);
                            previewWrapper.appendChild(removeBtn);
                            previewContainer.appendChild(previewWrapper);
                        };

                        reader.readAsDataURL(file);
                    }
                });

             // Manually update file input
             const dataTransfer = new DataTransfer();
        fileList.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
            }
        });

    </script>
</body>

</div>
</x-app-layout>


