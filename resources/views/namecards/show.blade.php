<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Name Card Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>

                            {{-- @php
                                $path = storage_path('app/public/namecards/' . $namecard);
                                dd($path);
                            @endphp --}}
                 <img src="{{ Storage::url($namecard->image_path) }}" alt="Name Card" class="w-full max-h-96 object-contain">

                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2">{{ $namecard->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ $namecard->company }}</p>
                            <p class="text-gray-600 mb-2">{{ $namecard->address }}</p>
                            <p class="text-gray-600 mb-2">Phone: {{ $namecard->phone }}</p>
                            <p class="text-gray-600 mb-2">Fax: {{ $namecard->fax }}</p>
                            <p class="text-gray-600 mb-2">Email: {{ $namecard->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</x-app-layout>
