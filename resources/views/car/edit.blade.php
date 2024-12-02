
<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg overflow-hidden">
                <div class="px-6 py-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-extrabold text-gray-900">車の詳細を編集する</h1>

                    </div>

                    <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="car_id" class="block text-sm font-medium text-gray-700 mb-2">車両ID</label>
                                <input type="text" name="car_id" id="car_id"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->car_id }}" required>
                            </div>

                            <div>
                                <label for="number_plate" class="block text-sm font-medium text-gray-700 mb-2">ナンバーパレット</label>
                                <input type="text" name="number_plate" id="number_plate"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->number_plate }}" required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="car_type" class="block text-sm font-medium text-gray-700 mb-2">車種</label>
                                <input type="text" name="car_type" id="car_type"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->car_type }}" required>
                            </div>

                            <div>
                                <label for="car_made_year" class="block text-sm font-medium text-gray-700 mb-2">車両製造日</label>
                                <input type="text" name="car_made_year" id="car_made_year"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->car_made_year }}" required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="car_insurance_company" class="block text-sm font-medium text-gray-700 mb-2">保険会社</label>
                                <input type="text" name="car_insurance_company" id="car_insurance_company"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->car_insurance_company }}" required>
                            </div>

                            <div>
                                <label for="etc" class="block text-sm font-medium text-gray-700 mb-2">ETC</label>
                                <input type="text" name="etc" id="etc"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->etc }}" required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="car_insurance_start" class="block text-sm font-medium text-gray-700 mb-2">保険開始</label>
                                <input type="date" name="car_insurance_start" id="car_insurance_start"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->car_insurance_start }}" required>
                            </div>

                            <div>
                                <label for="car_insurance_end" class="block text-sm font-medium text-gray-700 mb-2">保険終了日</label>
                                <input type="date" name="car_insurance_end" id="car_insurance_end"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $car->car_insurance_end }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">画像</label>
                            <input type="file" name="image_path" id="image_path"
                                class="w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">

                            @if($car->image_path)
                                <div class="mt-4 max-w-xs">
                                    <img src="{{ asset($car->image_path) }}" alt="Current Car Image" class="rounded-lg shadow-md">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="car_detail" class="block text-sm font-medium text-gray-700 mb-2">車両詳細</label>
                            <textarea name="car_detail" id="car_detail" rows="6"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >{{ $car->car_detail }}</textarea>
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ url('/car') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 transition ease-in-out duration-150">
                                Back to List
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 transition ease-in-out duration-150">
                      保存
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

