<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-sky-400 to-blue-500 p-6 rounded-xl shadow-lg mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">基本情報管理画面</h1>
            <h2 class="text-xl text-white font-medium">{{ auth()->user()->name }}</h2>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-6 sm:p-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">プロフィール更新</h3>

                <form method="POST" action="{{ route('myPage.profile') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">氏名</label>
                            <input type="text" id="name" name="name" required value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="furigana" class="block text-sm font-medium text-gray-700">氏名(ふりがな)</label>
                            <input type="text" id="furigana" name="furigana" required value="{{ old('furigana', $user->furigana) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">性別</label>
                            <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="男性" {{ old('gender', $user->gender) == '男性' ? 'selected' : '' }}>男性</option>
                                <option value="女性" {{ old('gender', $user->gender) == '女性' ? 'selected' : '' }}>女性</option>
                            </select>
                        </div>

                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">生年月日</label>
                            <input type="date" id="birthdate" name="birthdate" required value="{{ old('birthdate', $user->birthdate) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="post_number" class="block text-sm font-medium text-gray-700">郵便番号</label>
                            <input type="text" id="post_number" name="post_number" required value="{{ old('post_number', $user->post_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">住所</label>
                            <input type="text" id="address" name="address" required value="{{ old('address', $user->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">メール</label>
                            <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly>
                            <p class="mt-1 text-sm text-gray-500">※もしくは変更したい場合は管理者へ連絡してください</p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">新しいパスワード</label>
                            <input type="password" id="password" name="password" minlength="8" maxlength="20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <p class="mt-1 text-sm text-gray-500">※変更する場合のみ入力（8～20文字）</p>
                        </div>


                    </div>

                    <div class="flex justify-end mt-6">

                        <x-button purpose="search" type="submit">
                            更新
                        </x-button>
                        {{-- <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                            更新
                        </button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
