{{-- <x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto mt-5">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-t-xl shadow-lg">
                    <div class="p-6">
                        <h1 class="text-4xl font-extrabold text-white mb-2">社 内 回 覧</h1>

                    </div>
                </div>

                <div class="p-6">


<div class="mb-8">
    <div class="prose max-w-none text-2xl font-semibold text-center text-gray-800">
        {!! nl2br(e($innerNews->title)) !!}
    </div>
</div>
<div class="mb-8">
    <div class="prose max-w-none text-xl font-md ">
        {!! nl2br(e($innerNews->content)) !!}
    </div>
</div>

<div class="flex justify-end mb-2">
    {{ $innerNews->created_at->translatedFormat('Y年n月j日') }}
</div>

<div class="space-y-6">
    @foreach($innerNews->categories_data as $index => $categoryData)
        @php
            $category = \App\Models\NewsCategory::find($categoryData['category_id']);
        @endphp
        @if($category)
            <div class="border border-gray-400 rounded-lg p-4">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">
                    {{ $category->name }}
                </h3>
                <table class="table-auto w-full border-collapse border border-gray-400">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryData['fields'] as $fieldName => $value)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $fieldName }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if(is_array($value))
                                        {{ implode(', ', $value) }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach
</div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto mt-5">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-t-xl shadow-lg">
                    <div class="p-6">
                        <h1 class="text-4xl font-extrabold text-white mb-2">社 内 回 覧</h1>
                    </div>
                </div>

                <div class="p-6">
                    <!-- News Content -->


                    <div class="flex justify-end mb-2">
                        {{ $innerNews->created_at->translatedFormat('Y年n月j日') }}
                    </div>

                    <!-- Categories Table -->
                    <div class="space-y-6">
                        @php
                            $categoriesData = is_string($innerNews->categories_data)
                                ? json_decode($innerNews->categories_data, true)
                                : $innerNews->categories_data;
                        @endphp

                        @if(is_array($categoriesData))
                            @foreach($categoriesData as $index => $categoryData)
                                @if(isset($categoryData['category_id']))
                                    @php
                                        $category = \App\Models\NewsCategory::find($categoryData['category_id']);
                                    @endphp
                                    @if($category)
                                        <div class="border border-gray-400 rounded-lg p-4">
                                            <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">
                                                {{ $category->name }}
                                            </h3>
                                            <table class="table-auto w-full border-collapse border border-gray-400">
                                                <tbody>
                                                    @if(isset($categoryData['fields']) && is_array($categoryData['fields']))
                                                        @foreach($categoryData['fields'] as $fieldName => $value)
                                                            <tr>
                                                                <td class="border border-gray-300 px-4 py-2">{{ $fieldName }}</td>
                                                                <td class="border border-gray-300 px-4 py-2">
                                                                    @if(is_array($value))
                                                                        {{ implode(', ', $value) }}
                                                                    @else
                                                                        {{ $value }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
