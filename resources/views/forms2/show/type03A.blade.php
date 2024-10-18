<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-12">
        <div class="max-w-4xl mx-auto">



      <div class="bg-white shadow-xl rounded-lg overflow-hidden">




                <div class="px-6 py-8">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">会社案内、封筒依頼</h1>



                    <div class="bg-sky-100 p-6 rounded-lg mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">会社</label>
                                <input type="text" id="corp" name="corp" value="{{ $form->corp }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">営業所</label>
                                <input type="text" id="office" name="office" value="{{ $form->office }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">所属</label>
                                <input type="text" id="division" name="division" value="{{ $form->division }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">氏名</label>
                                <input type="text" id="name" name="name" value="{{ $form->name }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="companyProfile" class="block text-sm font-semibold text-gray-700 mb-1">会社案内</label>
                        <input type="number" id="companyProfile" name="companyProfile" value="{{ $form->companyProfile }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" readonly>
                    </div>

                    <div class="mb-6">
                        <label for="cover" class="block text-sm font-semibold text-gray-700 mb-1">封筒</label>
                        <input type="number" id="cover" name="cover" value="{{$form->cover}}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" readonly>
                    </div>

                    <div class="mb-6">
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">注文書</label>
                        <input type="number" id="order" name="order" value="{{$form->order}}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" readonly>
                    </div>

                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-semibold text-gray-700 mb-1">コメント</label>
                        <textarea id="comment" name="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"  readonly>{{ $form->comment }}</textarea>
                    </div>
                    
                    <div class="flex justify-between mt-4">
                        <x-button purpose="default" type="" href="{{route('applications2.index')}}" >
                            戻り
                        </x-button>
                
                    </div>


             
                </div>


         
        </div>
    </div>
</div>


</x-app-layout>
