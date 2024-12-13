
<x-app-layout>

    @if (session('success') || session('error'))
<div id="statusToast" class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
<div class="bg-gray-100 border-l-4 @if(session('success')) border-blue-500 @else border-red-500 @endif rounded-r-lg shadow-md overflow-hidden">
    <div class="p-4 flex items-center">
        <div class="flex-shrink-0">
            @if (session('success'))
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @else
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
        </div>
        <div class="ml-3 w-0 flex-1">
            @if (session('success'))
                <p class="text-lg font-semibold text-blue-900">
                    {!! session('success') !!}
                </p>
            @endif
            @if (session('error'))
                <p class="text-sm font-medium text-gray-900">
                    {{ session('error') }}
                </p>
            @endif


        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button id="closeToast" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
            閉じる
        </button>
    </div>
</div>
</div>

<style>
@keyframes slideDown {
    from { transform: translate(-50%, -100%); }
    to { transform: translate(-50%, 0); }
}
#statusToast {
    animation: slideDown 0.5s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var statusToast = document.getElementById('statusToast');
    var closeToast = document.getElementById('closeToast');

    var hideTimeout = setTimeout(function() {
        hideToast();
    }, 8000);

    closeToast.addEventListener('click', function() {
        clearTimeout(hideTimeout);
        hideToast();
    });

    function hideToast() {
        statusToast.style.transform = 'translate(-50%, -100%)';
        statusToast.style.transition = 'transform 0.5s ease-in-out';
        setTimeout(function() {
            statusToast.style.display = 'none';
        }, 500);
    }
});
</script>
@endif
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 bg-gradient-to-r from-sky-600 to-blue-600 p-5 rounded-xl px-10 py-10">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-white">
                        転売希望管理
                    </h1>
                    <p class="mt-4 text-sm text-white">
                       転売希望一覧
                    </p>
                </div>

                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                   新規求人投稿
                </a>
            </div>

            <div class="flex justify-end space-x-4 mb-4">




                {{-- <div class="flex space-x-4">
                    <form action="{{ route('products.pull-from-local') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                            Pull from Local Server
                        </button>
                    </form>

                    <form action="{{ route('products.push-to-local') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
                            Push to Local Server
                        </button>
                    </form>
                </div> --}}



                <!-- Import Form -->
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                    @csrf
                    <input type="file" name="excel_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring focus:ring-blue-200" required>
                    <button type="submit" class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 rounded-lg">
                        Import from Excel
                    </button>
                </form>




                    @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif












                    <!-- New auto import button -->
    <form action="{{ route('products.auto-import') }}" method="POST" class="flex items-center">
        @csrf
        <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-lg">
            Auto Import from Network
        </button>
    </form>

    <form action="{{ route('products.export') }}" method="POST" class="flex items-center">
        @csrf
        <button type="submit" class="px-4 py-2 text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded-lg">
            Export Updated Data to Excel
        </button>
    </form>









            </div>



            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <!-- Search and Filter Section -->
            <div class="mt-10 px-10">

                <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                    <input type="hidden" name="" value="">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="text" name="search" value="" class="border border-gray-300 rounded px-3 py-2 flex-grow" placeholder="商品番号、商品名、種類、メーカーで検索">
                        <x-button purpose="default" type="submit">
                            検索
                        </x-button>
                    </div>

                </form>

            </div>


                {{-- <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="検索...">
                                <button type="submit" class="ml-2 px-4 py-2 bg-indigo-500 text-white rounded-lg">Search</button>
                            </div>
                        </form>



                    </div>
                </div> --}}

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-200 border ">
                            <tr class="border-gray-300">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    順番
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    営業所
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    メーカー名
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    型番
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    商品名
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    棚卸数
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    ICM NET
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    仕入日
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    仕入先
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    定価
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    備考
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                                    action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 ">
                            @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    {{  $product->id}}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{  $product->office_name}}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{  $product->maker_name}}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->product_number }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->product_name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->pieces }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->icm_net }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->purchase_date }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->purchased_from }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->list_price }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->remarks }}
                                    </div>
                                </td>
                                <td class="">
                                    <div class="text-sm font-medium text-gray-900">
                                        <div class="flex space-x-2"> <!-- Use flex and space-x-2 to align buttons horizontally -->
                                            <a href="{{ route('products.edit', $product) }}" class="p-2 hover:bg-yellow-200 inline-block">
                                                <img src="{{ asset('2.svg') }}" alt="編集" class="w-8 h-8">
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 hover:bg-red-200 inline-block" onclick="return confirm('本当に消去しますか？')">
                                                    <img src="{{ asset('1.svg') }}" alt="消去" class="w-8 h-8">
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </td>









                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


