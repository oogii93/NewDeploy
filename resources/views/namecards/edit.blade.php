<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <div class="container mx-auto p-6">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">

            <h1 class="text-xl font-semibold mb-4 flex justify-center text-white bg-sky-400 px-2 py-2">名刺編集</h1>

            <div id="image-preview" class="mb-4">
                <img id="preview-img" class="max-w-full" src="{{ $namecard->image_path }}" alt="Captured Image">
            </div>

            <form id="namecard-form" method="POST" action="{{ route('namecards.update', $namecard->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="image_data" id="image-data" value="{{ $namecard->image_data }}">

                <div class="grid grid-cols-1 gap-1">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">
                            名前
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $namecard->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-semibold text-gray-600 mb-1">
                            会社名
                        </label>
                        <input
                            type="text"
                            id="company"
                            name="company"
                            value="{{ old('company', $namecard->company) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">
                            メールアドレス
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $namecard->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-600 mb-1">
                            電話番号
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $namecard->phone) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div>
                        <label for="mobile" class="block text-sm font-semibold text-gray-600 mb-1">
                            携帯電話
                        </label>
                        <input
                            type="tel"
                            id="mobile"
                            name="mobile"
                            value="{{ old('mobile', $namecard->mobile) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div>
                        <label for="fax" class="block text-sm font-semibold text-gray-600 mb-1">
                            FAX
                        </label>
                        <input
                            type="tel"
                            id="fax"
                            name="fax"
                            value="{{ old('fax', $namecard->fax) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-600 mb-1">
                            住所
                        </label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            value="{{ old('address', $namecard->address) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out placeholder-gray-400"
                        >
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            保存
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
