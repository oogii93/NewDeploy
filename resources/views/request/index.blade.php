{{-- <x-app-layout>
    <div class="flex justify-center items-center p-4 sm:p-6 mt-5">

    <div class="grid grid-cols-2 sm:grid-cols-3  lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-10 w-full max-w-6xl">

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all"">
        <a href=""></a>
        <span class="text-lg sm:text-xl lg:text-2xl">名刺作成依頼</span>
    </div>

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
        <span class="text-lg sm:text-xl lg:text-2xl">制服注文依頼</span>
    </div>

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
        <span class="text-lg sm:text-xl lg:text-2xl">携帯支給依頼</span>
    </div>

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
        <span class="text-lg sm:text-xl lg:text-2xl">PC支給・返却依頼</span>
    </div>

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
        <span class="text-lg sm:text-xl lg:text-2xl">会社案内、封筒依頼</span>
    </div>

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
        <span class="text-lg sm:text-xl lg:text-2xl">同好会 参加申込、活動状況</span>
    </div>

    <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
        <span class="text-lg sm:text-xl lg:text-2xl">エクシブの申し込み</span>
    </div>

</div>
</div>
</div>




</x-app-layout> --}}

<x-app-layout>
    <div class="flex justify-center items-center p-4 sm:p-6 mt-5">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-10 w-full max-w-6xl">
            @foreach ($formTypes as $type => $form)
                <div class="col-span-1 h-24 sm:h-28 lg:h-32 flex items-center justify-center text-gray-700 font-bold text-center rounded-lg cursor-pointer bg-teal-400 hover:bg-teal-500 transition-all">
                    <a href="{{ route('request.form', ['type' => $type]) }}" class="w-full h-full flex items-center justify-center">
                        <span class="text-lg sm:text-xl lg:text-2xl">{{ $form['title'] }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>


