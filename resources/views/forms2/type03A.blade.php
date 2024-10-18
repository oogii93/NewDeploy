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



    <div class="bg-gray-100 min-h-screen py-12">
        <div class="max-w-4xl mx-auto">



            <form action="{{ route('forms2.store', '03A') }}" method="POST" class="bg-white shadow-xl rounded-lg overflow-hidden">
                @csrf

                <div class="px-6 py-8">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">会社案内、封筒依頼</h1>

                    {{-- @if ($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">入力エラー</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <div class="bg-sky-100 p-6 rounded-lg mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">会社</label>
                                <input type="text" id="corp" name="corp" value="{{ Auth::user()->corp->corp_name ?? 'N/A' }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">営業所</label>
                                <input type="text" id="office" name="office" value="{{ Auth::user()->office->office_name ?? 'N/A' }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">所属</label>
                                <input type="text" id="division" name="division" value="{{ Auth::user()->division->name ?? 'N/A' }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">氏名</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? 'N/A' }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="companyProfile" class="block text-sm font-semibold text-gray-700 mb-1">会社案内</label>
                        <input type="number" id="companyProfile" name="companyProfile" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="１０部">
                    </div>

                    <div class="mb-6">
                        <label for="cover" class="block text-sm font-semibold text-gray-700 mb-1">封筒</label>
                        <input type="number" id="cover" name="cover" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="１００枚">
                    </div>

                    <div class="mb-6">
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">注文書</label>
                        <input type="number" id="order" name="order" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="１００冊">
                    </div>

                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-semibold text-gray-700 mb-1">コメント</label>
                        <textarea id="comment" name="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="内容"></textarea>
                    </div>


                    <x-button type="submit" purpose="search">
                        提出する
                    </x-button>
                </div>


            </form>
        </div>
    </div>


</x-app-layout>
