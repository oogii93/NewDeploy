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
                  倉庫管理

                </h1>


                <h1 class="text-2xl font-bold mb-4 text-left py-4 px-2">{{ $office->corp->corp_name }}
                    <br><span class="text-gray-700">{{ $office->office_name }} 倉庫一覧 </span>
                </h1>

                <div class="flex flex-wrap gap-2 mb-4 px-2">
                    <x-button purpose="search" href="{{ route('warehouse.create',['office_id'=>$office->id]) }}">
                        新規登録
                    </x-button>


                </div>

  <div>
    <form action="{{ route('warehouse.index2') }}" method="GET" class="mb-4">
        <input type="hidden" name="office_id" value="{{ $office->id }}">
        <div class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="border border-gray-300 rounded px-3 py-2 flex-grow" placeholder="商品番号、商品名、種類、メーカーで検索">
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
                                        商品番号</th>

                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        画像</th>
                                        <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                        商品名</th>
                                    <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                        種類</th>
                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        メーカー</th>
                                    <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                        数量</th>


                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-sky-50">
                                        <td class="border border-slate-300 px-4 py-2 hide-on-mobile">
                                            {{ $product->product_code }}</td>


                                        <td class="border border-slate-300 py-3">
                                       @if($product->image_path)
                                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->product_name }}" class="w-40 h-32 object-cover">
                                        @else
                                            No image
                                        @endif
                                        </td>
                                        <td class="border border-slate-300 py-3 hide-on-mobile">
                                            {{ $product->product_name}}
                                        </td>

                                        <td class="border border-slate-300 py-3 hide-on-mobile">
                                            {{ $product->product_type}}

                                        </td>
                                        <td class="border border-slate-300 px-4 py-2">{{ $product->product_maker}}</td>
                                        <td class="border border-slate-300 px-4 py-2 hide-on-mobile">{{ $product->quantity }}
                                        </td>



                                        <td class="border border-slate-300 px-4 py-2" data-label="動作">
                                            <div class="flex space-x-2"> <!-- Use flex and space-x-2 to align buttons horizontally -->
                                                <a href="{{ route('warehouse.edit', $product->id) }}" class="p-2 hover:bg-yellow-200 inline-block">
                                                    <img src="{{ asset('2.svg') }}" alt="編集" class="w-8 h-8">
                                                </a>
                                                <form action="{{ route('warehouse.destroy', $product->id) }}" method="POST" class="inline-block">
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
                 {{ $products->appends(['office_id'=>$office->id, 'search'=>$search])->links() }}
                    </div>
                </div>
</div>







</x-app-layout>
