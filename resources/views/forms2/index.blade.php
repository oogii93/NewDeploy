{{-- <x-app-layout>

    @if (session()->has('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if (session()->has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">社内注文</h1>

        <form method="GET" action="{{ route('forms2.index') }}" class="py-3 content-center">
            <input type="text" name="search" placeholder="Search by title" value="{{ request('search') }}">
            <x-button purpose="submit" type="submit">
                検索
            </x-button>
        </form>


        @foreach  ($formGroups as $groupName => $forms)
            <div class="mb-4 border border-gray-300 rounded-lg shadow-sm">
                <button class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-green-200 focus:outline-none transition duration-150 ease-in-out" onclick="toggleFolder(this)">
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-semibold text-gray-700">
                            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            {{ $groupName }}
                        </span>
                        <svg class="w-5 h-5 transform transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div class="hidden">
                    <ul class="py-2 px-4 space-y-2">
                        @foreach ($forms as $key => $form)
                            <li>
                                @if (isset($form['subforms']))
                                    <div class="mb-2">
                                        <button onclick="toggleSubforms(this)" class="text-blue-600 hover:text-blue-800 hover:underline transition duration-150 ease-in-out">
                                            {{ $form['title'] }}
                                        </button>
                                        <div class="hidden ml-4 mt-2">
                                            @foreach ($form['subforms'] as $subKey => $subForm)
                                                <a href="{{ route('forms2.show', $key . '-' . $subKey) }}" class="block text-blue-600 hover:text-blue-800 hover:underline transition duration-150 ease-in-out">
                                                    {{ $subForm['title'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('forms2.show', $key) }}" class="text-blue-600 hover:text-blue-800 hover:underline transition duration-150 ease-in-out">
                                        {{ $form['title'] }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach

{{-- one section
 @if(!empty($filteredGroups))
        @foreach($filteredGroups as $groupName =>$forms)

        @endforeach
    @else
    <p>no result</p>
    @endif

    @if(!empty($relevantInstructions))
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Q＆A</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($relevantInstructions as $instruction)
                <div class="bg-white p-4 rounded shadow">
                    <div class="text-blue-500 font-bold">Q</div>
                    <div class="font-semibold mt-2">{{ $instruction['question'] }}</div>
                    <div class="mt-2">A</div>
                    <div class="mt-2">{{ $instruction['answer'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif --}}



        {{-- <div class="container mx-auto p-6 bg-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Question -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="text-blue-500 font-bold">Q</div>
                    <div class="font-semibold mt-2">ECサイトのGMV増減によりサービス利用料金は変わりますか？</div>
                    <div class="mt-2">A</div>
                    <div class="mt-2">ECサイトのGMVにもとづた複数のプランをご用意しております。ご適用される料金プランは、前月のGMVに応じて自動で変更されます。詳細は本資料のページを参照してください。</div>
                </div>

                <!-- Second Question -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="text-blue-500 font-bold">Q</div>
                    <div class="font-semibold mt-2">申込みからどれくらいで利用できますか？</div>
                    <div class="mt-2">A</div>
                    <div class="mt-2">お客様情報の登録により異なりますが、お申込み後２週間程度でご利用開始日をご案内させていただきます。申込み内容にお客様独自にAPI接続が必要な場合は別途お問い合わせください。</div>
                </div>

                <!-- Third Question -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="text-blue-500 font-bold">Q</div>
                    <div class="font-semibold mt-2">API接続にあたってサポートは受けられますか？</div>
                    <div class="mt-2">A</div>
                    <div class="mt-2">アカウント発行の際に専任サポート担当者をご案内させていただきます。実装上の様々なご相談やサービス利用上でのご相談まで幅広く対応可能ですのでお気軽にご相談ください。</div>
                </div>

                <!-- Fourth Question -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="text-blue-500 font-bold">Q</div>
                    <div class="font-semibold mt-2">どのような支払い方法がありますか？請求書払いには対応していますか？</div>
                    <div class="mt-2">A</div>
                    <div class="mt-2">クレジットカード払い、請求書払い（口座振込）をご利用いただけます。また、支払い方法はサポートサイトにてご登録いただけます。</div>
                </div>
            </div>
        </div> --}}

    {{-- </div>
</div>

    <script>
        function toggleFolder(button) {
            const folder = button.nextElementSibling;
            const arrow = button.querySelector('svg:last-child');

            folder.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function toggleSubforms(button) {
            const subforms = button.nextElementSibling;
            subforms.classList.toggle('hidden');
        }
    </script>
</x-app-layout>  --}}

<x-app-layout>
    @if (session()->has('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl font-bold text-gray-700 flex items-center">
                        <svg class="w-8 h-8 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        本社へ注文フォーム一覧
                    </div>

                    <div class="mt-6 text-gray-500">
                        各フォームに入って内容を入力してから送信ボタンを押してください。
                    </div>
                </div>

                <div class="bg-stone-400 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    @php
                        $colors = [
                            ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-800', 'icon' => 'text-yellow-600'],
                            ['bg' => 'bg-green-50', 'text' => 'text-green-800', 'icon' => 'text-green-600'],
                            ['bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'icon' => 'text-blue-600'],
                            ['bg' => 'bg-purple-50', 'text' => 'text-purple-800', 'icon' => 'text-purple-600'],
                            ['bg' => 'bg-pink-50', 'text' => 'text-pink-800', 'icon' => 'text-pink-600'],
                            ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-800', 'icon' => 'text-indigo-600'],
                        ];
                    @endphp

                    @foreach($forms as $key => $form)
                        @php
                            $color = $colors[$loop->index % count($colors)];
                        @endphp
                        <div class="scale-100 p-6 {{ $color['bg'] }} dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500">
                            <div>
                                <div class="h-16 w-16 {{ $color['bg'] }} dark:bg-indigo-900/20 flex items-center justify-center rounded-full">
                                    <svg class="w-8 h-8 {{ $color['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold {{ $color['text'] }} dark:text-white">{{ $form['title'] }}</h2>

                                <p class="mt-4 {{ $color['text'] }} dark:text-gray-400 text-sm leading-relaxed">
                                    このフォームを使用して申請を行います。クリックして詳細を表示し、必要事項を入力してください。
                                </p>
                            </div>

                            <a href="{{ route('forms2.show', $key) }}" class="absolute top-0 right-0 p-6 text-sm font-semibold {{ $color['text'] }} bg-white rounded-bl-2xl hover:{{ $color['bg'] }} focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                フォームを見る
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

