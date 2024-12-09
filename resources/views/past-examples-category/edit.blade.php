<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">

        <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from blue-500 to-blue-400 p-6">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">

                     カテゴリ編集
                </h1>
            </div>

            <form action="{{ route('past-examples-category.update', $category->id) }}" method="POST" class="p-8 space-y-6">

                @csrf
                @method('PUT')

                    <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                カテゴリ名
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $category->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                                required
                                placeholder="カテゴリ名を編集してください。"
                            >
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between space-x-4">
                            <a href="{{ route('past-examples-category.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 text-center">
                                戻り
                            </a>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-teal-400 hover:from-blue-600 hover:to-teal-500 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                更新
                            </button>
                        </div>
            </form>

    </div>
</x-app-layout>
