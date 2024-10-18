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



            <form action="{{ route('forms2.store', '01A') }}" method="POST" class="bg-white shadow-xl rounded-lg overflow-hidden">
                @csrf

                <div class="px-6 py-8">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">制服注文依頼</h1>

               

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
                            {{-- <div class="md:col-span-3 hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">性別</label>
                                <input type="text" id="gender" name="gender" value="{{ Auth::user()->gender ?? 'N/A' }}" class="w-full text-gray-800 border-1 rounded-md p-2" readonly>
                            </div> --}}
                        </div>
                    </div>
                            <!-- Conditional inputs based on gender -->
                            <div class="mb-6">
                                @if (strtolower(Auth::user()->gender) == '男性')
                                    <label for="male_specific_field" class="block text-sm font-semibold text-gray-700 mb-1">男性用フィールド</label>
                                    <input type="text" id="1" name="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="男性用の特定フィールドを入力してください">

                                @elseif (strtolower(Auth::user()->gender) == '女性')

                                <div class="border-2 border-blue-200">
                                    <div class="px-2 py-2">
                                        <h2 class="flex justify-center font-semibold text-2xl text-gray-700 mt-2">注文</h2>
                                        <label for="female_specific_field" class="block text-sm font-semibold text-gray-700 mb-1">女性用フィールド</label>
                                        <input type="text" id="2" name="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="女性用の特定フィールドを入力してください">
                                    </div>


                                    <div class="px-2 py-2 mt-3">
                                  
                                
                                        <!-- Use flex to display select options side by side -->
                                        <div class="flex space-x-4">
                                            <div class="w-1/3">
                                                <label for="jacket" class="block text-sm font-semibold text-gray-700 mb-1">女性用交換</label>
                                                <select id="jacket" name="jacket" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="" disabled selected>選択してください</option>
                                                    <option value="jacket" class="text-center font-semibold">ジャケット</option>
                                                    <option value="squrt" class="text-center font-semibold">スカート</option>
                                                    <option value="vast" class="text-center font-semibold">ベスト</option>
                                                    <option value="pants" class="text-center font-semibold">パンツ</option>
                                                </select>
                                            </div>
                                
                                            <div class="w-1/3">
                                                <label for="size" class="block text-sm font-semibold text-gray-700 mb-1">サイズ</label>
                                                <select id="size" name="size" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="" disabled selected>サイズを選択してください</option>
                                                    <option value="XS" class="text-center font-semibold">XS</option>
                                                    <option value="S" class="text-center font-semibold">S</option>
                                                    <option value="M" class="text-center font-semibold">M</option>
                                                    <option value="L" class="text-center font-semibold">L</option>
                                                </select>
                                            </div>
                                            <div class="w-1/3">
                                                <label for="size" class="block text-sm font-semibold text-gray-700 mb-1">枚</label>
                                                 <input type="number" id="reason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="入力してください">
                                              
                                            </div>
                                            
                                        </div>
                                        <label for="reason" class="block text-sm font-semibold text-gray-700 mb-1 mt-3">交換理由</label>
                                        <input type="text" id="reason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="交換理由を入力してください">
                                    
                                                  
                                    </div>
                                </div>
                                   
                                </div>
                                <div class="border-2 border-green-200 mt-5">
                                    <div class="px-2 py-2">
                                        <h2 class="flex justify-center font-semibold text-2xl text-gray-700 mt-2">交換</h2>


                                <div>
                                  
                                
                                        <!-- Use flex to display select options side by side -->
                                        <div class="flex space-x-4">
                                            <div class="w-1/3">
                                                <label for="jacket" class="block text-sm font-semibold text-gray-700 mb-1">女性用交換</label>
                                                <select id="jacket" name="jacket" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="" disabled selected>選択してください</option>
                                                    <option value="jacket" class="text-center font-semibold">ジャケット</option>
                                                    <option value="squrt" class="text-center font-semibold">スカート</option>
                                                    <option value="vast" class="text-center font-semibold">ベスト</option>
                                                    <option value="pants" class="text-center font-semibold">パンツ</option>
                                                </select>
                                            </div>
                                
                                            <div class="w-1/3">
                                                <label for="size" class="block text-sm font-semibold text-gray-700 mb-1">サイズ</label>
                                                <select id="size" name="size" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="" disabled selected>サイズを選択してください</option>
                                                    <option value="XS" class="text-center font-semibold">XS</option>
                                                    <option value="S" class="text-center font-semibold">S</option>
                                                    <option value="M" class="text-center font-semibold">M</option>
                                                    <option value="L" class="text-center font-semibold">L</option>
                                                </select>
                                            </div>
                                            <div class="w-1/3">
                                                <label for="size" class="block text-sm font-semibold text-gray-700 mb-1">枚</label>
                                                 <input type="number" id="reason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="入力してください">
                                              
                                            </div>
                                            
                                        </div>
                                        <label for="reason" class="block text-sm font-semibold text-gray-700 mb-1 mt-3">交換理由</label>
                                        <input type="text" id="reason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="交換理由を入力してください">
                                    
                                                  
                                    </div>
                                </div>
                                </div>
                                
                             

                            
                              
                                @endif
                            </div>




                    <x-button type="submit" purpose="search">
                        提出する
                    </x-button>
                </div>


            </form>
        </div>
    </div>


</x-app-layout>
