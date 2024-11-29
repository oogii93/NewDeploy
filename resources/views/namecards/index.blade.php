

<x-app-layout>




    <div class="flex justify-center mt-1">
        @if (session('success'))
            <div id="flash-message" class="bg-sky-200 border border-blue-300 text-blue-800 px-6 py-4 rounded-lg shadow-lg flex items-center max-w-xl w-full">
                <svg class="w-6 h-6 mr-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-11a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V7zm0 4a1 1 0 011 1v2a1 1 0 102 0v-2a1 1 0 10-2 0H9v-2a1 1 0 00-1-1H8a1 1 0 100 2h1v1z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-200 border border-red-300 text-red-800 px-6 py-4 rounded-lg shadow-lg flex items-center max-w-xl w-full mt-4">
                <svg class="w-6 h-6 mr-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 11-12 0 6 6 0 0112 0zm-1 1a1 1 0 00-2 0v2a1 1 0 002 0V9zm-4 1a1 1 0 00-1-1H7a1 1 0 000 2h6a1 1 0 001-1z" clip-rule="evenodd" />
                </svg>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>





    <script>
        // Wait for the DOM to be ready
        document.addEventListener("DOMContentLoaded", function() {
            // Select the flash message
            var flashMessage = document.getElementById('flash-message');

            // If there's a flash message, set a timer to remove it after 5 seconds
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.transition = "opacity 0.5s ease-out";
                    flashMessage.style.opacity = "0";

                    setTimeout(function() {
                        flashMessage.remove();
                    }, 500); // Ensure the message is removed after the fade-out transition
                }, 5000); // 5 seconds delay
            }
        });
    </script>


<div class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow overflow-hidden">
        <div class="container mx-auto px-4 py-8">

            <div class="shadow overflow-hidden rounded border-b border-gray-200 bg-white mt-10 p-4 sm:p-6 lg:p-8">



                <h1 class="px-2 py-2 text-xl font-medium mb-6 mt-5">
                  名刺管理

                </h1>




                <div class="flex flex-wrap gap-2 mb-4 px-2">
                    <x-button purpose="search" href="{{ route('namecards.create') }}">
                        新規登録
                    </x-button>


                </div>

  <div>
    <form action="" method="GET" class="mb-4">
        <input type="hidden" name="office_id" value="">
        <div class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="" class="border border-gray-300 rounded px-3 py-2 flex-grow" placeholder="商品番号、商品名、種類、メーカーで検索">
            <x-button purpose="default" type="submit">
                検索
            </x-button>
        </div>

    </form>
  </div>

            </div>


                    <div class="table-responsive mt-10">
                        <table class="border-collapse border border-slate-400 min-w-full bg-white mt-5">
                            <thead class="bg-gray-200 text-black">
                                <tr>
                                    <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                        会社名</th>

                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        画像</th>
                                        <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                        名刺名</th>
                                    <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                        電話番号</th>




                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        メールアドレス</th>

                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($namecards as $namecard)
                                    <tr class="border-b border-gray-200 hover:bg-sky-50">
                                        <td class="border border-slate-300 px-4 py-2 hide-on-mobile">
                                            {{ $namecard->company }}</td>


                                      <td class="border border-slate-300 py-3">
    @if($namecard->image_path)
        <img src="{{ Storage::url($namecard->image_path) }}" alt="Name Card" class="w-40 h-32 object-cover">
    @else
        No image
    @endif
</td>

                                        <td class="border border-slate-300 py-3 hide-on-mobile">
                                            {{ $namecard->name}}
                                        </td>

                                        <td class="border border-slate-300 py-3 hide-on-mobile">
                                            {{ $namecard->phone}}

                                        </td>
                                        <td class="border border-slate-300 px-4 py-2">{{ $namecard->address}}</td>
                                        <td class="border border-slate-300 px-4 py-2 hide-on-mobile">{{ $namecard->email }}
                                        </td>



                                        <td class="border border-slate-300 px-4 py-2" data-label="動作">
                                            <div class="flex space-x-2"> <!-- Use flex and space-x-2 to align buttons horizontally -->
                                                <a href="{{ route('namecards.show', $namecard->id) }}" class="p-2 hover:bg-yellow-200 inline-block">
                                                    <img src="{{ asset('2.svg') }}" alt="編集" class="w-8 h-8">
                                                </a>
                                                <form action="{{ route('namecards.destroy', $namecard->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 hover:bg-red-200 inline-block" onclick="return confirm('本当に消去しますか？')">
                                                        <img src="{{ asset('1.svg') }}" alt="消去" class="w-8 h-8">
                                                    </button>
                                                </form>



                                            </div>
                                        </td>



                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">

                    </div>
                </div>
</div>







</x-app-layout>

