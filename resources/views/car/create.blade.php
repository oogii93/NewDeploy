<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-6">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">
                    車両管理 - 新規登録
                </h1>
            </div>

            <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="car_id" class="block text-sm font-medium text-gray-700 mb-2">
                            車両ID
                        </label>
                        <input
                            type="text"
                            name="car_id"
                            id="car_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>

                    <div>
                        <label for="number_plate" class="block text-sm font-medium text-gray-700 mb-2">
                            ナンバープレート
                        </label>
                        <input
                            type="text"
                            name="number_plate"
                            id="number_plate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="car_type" class="block text-sm font-medium text-gray-700 mb-2">
                            車種
                        </label>
                        <input
                            type="text"
                            name="car_type"
                            id="car_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>

                    <div>
                        <label for="car_made_year" class="block text-sm font-medium text-gray-700 mb-2">
                            車の製造年
                        </label>
                        <input
                            type="text"
                            name="car_made_year"
                            id="car_made_year"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="car_insurance_company" class="block text-sm font-medium text-gray-700 mb-2">
                            保険会社
                        </label>
                        <input
                            type="text"
                            name="car_insurance_company"
                            id="car_insurance_company"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>

                    <div>
                        <label for="etc" class="block text-sm font-medium text-gray-700 mb-2">
                            Etc
                        </label>
                        <input
                            type="text"
                            name="etc"
                            id="etc"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="car_insurance_start" class="block text-sm font-medium text-gray-700 mb-2">
                            保険開始日付け
                        </label>
                        <input
                            type="date"
                            name="car_insurance_start"
                            id="car_insurance_start"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>

                    <div>
                        <label for="car_insurance_end" class="block text-sm font-medium text-gray-700 mb-2">
                            保険終了日
                        </label>
                        <input
                            type="date"
                            name="car_insurance_end"
                            id="car_insurance_end"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                            required
                        >
                    </div>
                </div>

                <div>
                    <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">
                        画像
                    </label>
                    <input
                        type="file"
                        name="image_path"
                        id="image_path"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                        required
                    >
                </div>

                <div>
                    <label for="car_detail" class="block text-sm font-medium text-gray-700 mb-2">
                        車詳細
                    </label>
                    <textarea
                        name="car_detail"
                        id="car_detail"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                    ></textarea>
                </div>

                <div class="flex justify-between space-x-4">
                    <a href="{{ url('/car') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 text-center">
                        戻り
                    </a>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-teal-400 hover:from-blue-600 hover:to-teal-500 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        保存
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
