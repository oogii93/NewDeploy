<x-app-layout>

    <script src="https://res.cdn.office.net/quickassist/v1/QuickAssist.js"></script>
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
                    <div class="mt-3 text-2xl font-bold text-gray-700 flex items-center">
                        <svg
                        class="w-16 h-16"
                        version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="160" y="357.424" style="fill:#333333;" width="192" height="108.336"></rect> <polygon points="160,376.16 274.24,376.16 160,434.064 "></polygon> <path style="fill:#999999;" d="M377.456,487.84H134.544c-9.424,0-17.12-7.712-17.12-17.12l0,0c0-9.424,7.712-17.12,17.12-17.12 H377.44c9.424,0,17.12,7.712,17.12,17.12l0,0C394.576,480.144,386.864,487.84,377.456,487.84z"></path> <path style="fill:#D6D6D6;" d="M480,376.16H32c-17.6,0-32-14.4-32-32v-288c0-17.6,14.4-32,32-32h448c17.6,0,32,14.4,32,32v288 C512,361.76,497.6,376.16,480,376.16z"></path> <rect x="21.968" y="46.096" style="fill:#0BA4E0;" width="468.16" height="308.128"></rect> <path style="fill:#FFFFFF;" d="M341.088,285.312H170.912c-31.184,0-56.56-25.376-56.56-56.56c0-25.536,16.96-47.504,41.088-54.352 c-0.016-0.464-0.016-0.928-0.016-1.408c0-39.28,31.952-71.232,71.232-71.232c28.08,0,53.408,16.608,64.848,41.904 c2.816-0.56,5.648-0.832,8.496-0.832c19.056,0,35.648,11.824,42.048,29.344c30.736,0.512,55.584,25.68,55.584,56.544 C397.648,259.936,372.272,285.312,341.088,285.312z"></path> </g></svg>
                      <span class="px-5">  本社へパソコン問い合わせフォーム一覧</span>
                    </div>

                    <div class="border-1 border-b border-gray-400 w-full mt-2"></div>



                    <div class="flex items-center justify-between gap-6 my-6">
                        <!-- Search Bar -->






                        <div class="w-full max-w-md">
                            <div class="relative flex items-center">

                                @foreach($formComputer as $key => $form)

                                <a href="{{ route('ComputerForm', $key) }}"

                                          class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold text-white bg-blue-500 border border-blue-500 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                <svg
                                class="w-20 h-20"
                                viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M853.333333 960H170.666667V64h469.333333l213.333333 213.333333z" fill="#90CAF9"></path><path d="M821.333333 298.666667H618.666667V96z" fill="#E1F5FE"></path><path d="M341.333333 448h362.666667v42.666667H341.333333zM341.333333 533.333333h277.333334v42.666667H341.333333zM341.333333 618.666667h362.666667v42.666666H341.333333zM341.333333 704h277.333334v42.666667H341.333333z" fill="#1976D2"></path></g></svg>
                                 問い合わせ申請する
                                </a>
                                @endforeach

                            </div>
                        </div>

                        <div class="w-full max-w-md">
                            <div class="relative flex items-center">
                                <button
                                    id="quickAssistButton"

                                       class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold text-white bg-emerald-500 border border-green-500 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"

                                >
                                    <img
                                        src="{{ asset('images/ada.png') }}"
                                        class="w-20 h-20 mr-2"
                                        alt="Assist Icon"
                                    >
                                    画面共有（クイックアシスト）
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="w-full max-w-md mt-10 ">
                        <form action="{{ route('ComputerForm.index') }}" method="GET" class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input
                                type="search"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                placeholder="キーワードで検索..."
                                class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out shadow-sm hover:border-blue-400"
                            >
                            <button
                                type="submit"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-blue-700 rounded-r-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition duration-300 ease-in-out"
                            >
                                検索
                            </button>
                        </form>
                    </div>
                    <div class="mt-6 text-gray-500">
                        よくあるパソコンの問題の実例をここで検索してください。
                    </div>








                </div>

                <div class="bg-stone-200 ">





                    <div class="container mx-auto px-4 py-8">

                        <div class="mb-5 text-xl font-semibold text-gray-700 flex justify-center">


                        <svg
                          class="w-8 h-8 mb-2"
                        fill="#000000" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M287 435q-42 0-74.5 18.5t-51 52.5-18.5 77 18.5 76.5 51.5 52 74 18.5q38 0 67-15l-92-92h74l60 59q16-18 24-39 11-26 11-60 0-43-18.5-77T361 453.5 287 435zm590-328h-57q-10 0-19.5-5T786 89l-39-72q-6-8-14.5-12.5t-18-4.5T696 4.5 682 17l-39 72q-6 8-15 13t-19 5h-58q-33 0-61 16.5t-44.5 45T429 230v56H123q-34 0-62 16.5T16.5 347 0 408v362q0 33 16.5 61.5t44.5 45 62 16.5h69q11 0 20 5t15 13l26 72q6 8 14.5 12.5t18.5 4.5 18.5-4.5T318 983l27-72q6-8 15-13t19-5h70q33 0 61-16.5t44.5-45T572 770v-56h305q34 0 62-16.5t44.5-44.5 16.5-61V230q0-33-16.5-61.5t-44.5-45-62-16.5zM426 786l-29-30q-46 30-110 30-58 0-104.5-26.5t-73-73T83 583t26.5-103.5 73-73.5 104-27T391 406t73.5 73.5T491 583q0 82-54 140l63 63h-74zm503-194q0 21-15.5 36T877 643H571v-52h14l42-94h168l41 94h64L715 177 571 482v-74q0-35-19-65.5T500 297v-67q0-21 15-36t36-15h70q22 0 34.5-7t20.5-21q6-9 14-31 7-18 11-26.5t13.5-8.5 12.5 8l10 27q10 28 15 36 8 13 19.5 18t36.5 5h69q21 0 36.5 15t15.5 36v362zM652 440l60-132 59 132H652z"></path></g>
                        </svg>
                        <span

                        class="px-2">
                            よくある問題やその解決方法
                        </span>

                    </div>



                        @if($pastExamples->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
                                @foreach ($pastExamples as $pastExample)
                                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg transform transition duration-300 hover:bg-gray-100 hover:shadow-xl">
                                        <div class="p-6">
                                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3 truncate">
                                                {{ $pastExample->title }}
                                            </h3>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                                {!! Str::limit(strip_tags($pastExample->description), 150) !!}
                                            </div>
                                            <div class="flex justify-end mt-4">
                                                <a
                                                    href="{{ route('admin.past-examples.show', $pastExample) }}"
                                                    class="px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:-translate-y-0.5"
                                                >
                                                    詳細を見る
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-8 flex justify-center">
                                {{ $pastExamples->appends(request()->query())->links('') }}
                            </div>
                        @else
                            <div class="text-center py-12 max-w-md mx-auto">
                                <p class="text-xl text-gray-500 dark:text-gray-400">
                                    検索結果が見つかりませんでした。
                                </p>
                            </div>
                        @endif
                    </div>





                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        const quickAssistIntegrationId = 'YOUR_QUICKASSIST_INTEGRATION_ID';

document.getElementById('quickAssistButton').addEventListener('click', () => {

    window.location.href = 'ms-quick-assist:';
});
    </script>
</x-app-layout>
