
<x-app-layout>

    <div class="mt-5 mb-5 flex justify-center">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>問い合わせ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

    <div class="w-full max-w-4xl bg-white shadow-lg rounded-xl p-8">

        <div class=" overflow-hidden">


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
                        value="{{ $form->corp}}"
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
                        value="{{ $form->office }}"
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
                        value="{{ $form->name }}"
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
                        value="{{ $form->occured_date }}"
                        required
                        readonly
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
                        readonly
                        value=""
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="発生頻度を含め、インシデントの詳細な説明を提供する"
                    >{{ $form->description }}</textarea>
                </div>

                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">
                        回答期限
                    </label>
                    <select
                        id="answer"
                        name="answer"
                      readonly
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                        <option value="">選択</option>
                        <option value="優先度" {{ $form->answer =='優先度' ? 'selected' : '' }}>優先度</option>
                        <option value="緊急度" {{ $form->answer == '緊急度' ? 'selected' : '' }}>緊急度</option>

                    </select>
                </div>

                <div class="col-span-full">
                    <label for="screen_copy" class="block text-sm font-medium text-gray-700 mb-2">
                        画面コピー (スクリーンショット)
                    </label>

                    {{-- <div
                    id="drop-zone"
                    class="w-full p-6 border-2 border-dashed border-gray-300 rounded-lg text-center transition-all duration-300 hover:border-blue-500 hover:bg-blue-50"
                >
                    <input
                        type="file"
                        id="screen_copy"
                        name="screen_copy"
                        accept="image/*"
                        class="hidden"
                    > --}}

                    {{-- <div  id="drop-zone-text" class="text-gray-500">
                        <p>ファイルをドラッグ＆ドロップ、または<label for="screen_copy" class="text-blue-600 cursor-pointer hover:underline">クリックしてアップロード</label></p>
                        <p class="text-xs mt-2">PNG、JPG、GIF (最大5MB)</p>

                    </div> --}}

                </div>

                <div id="preview-container" class="mt-4 grid grid-cols-1 gap-4 col-span-full">
                    @if($form->screen_copy)
                        @php
                            // Decode the JSON array stored in the `screen_copy` column
                            $screenCopies = json_decode($form->screen_copy, true);
                        @endphp

                        @foreach($screenCopies as $screenCopy)
                            <div class="relative w-[800]">
                                <img src="{{ Storage::url($screenCopy) }}"
                                     alt="Uploaded Screenshot"
                                     class="rounded-lg w-full h-auto object-cover">
                            </div>
                        @endforeach
                    @endif
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
                    >{{ $form->self_attempt }}</textarea>
                </div>
            </div>

            <div class="flex justify-between px-2 py-2 mb-5">
                <x-button purpose="default" type="" href="{{ route('applications2.computer') }}">
                  戻り
                </x-button>
            </div>


        </div>
    </div>

</body>

</div>
</x-app-layout>


