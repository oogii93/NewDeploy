<x-app-layout>
    <div class="max-w-6xl mx-auto p-8 bg-white shadow-lg rounded-xl mt-10">
        <h1 class="text-3xl font-bold text-center text-gray-700 mb-8">社員データ</h1>




            <div class="flex justify-center mt-1">
                @if (session('success'))
                    <div id="flash-message" class="bg-sky-200 border border-blue-300 text-blue-800 px-6 py-4 rounded-lg shadow-lg flex items-center max-w-xl w-full">
                        <svg class="w-6 h-6 mr-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-11a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V7zm0 4a1 1 0 011 1v2a1 1 0 102 0v-2a1 1 0 10-2 0H9v-2a1 1 0 00-1-1H8a1 1 0 100 2h1v1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-200 border border-red-300 text-red-800 px-6 py-4 rounded-lg shadow-lg flex items-center max-w-xl w-full mt-4">
                        <svg class="w-6 h-6 mr-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 8a6 6 0 11-12 0 6 6 0 0112 0zm-1 1a1 1 0 00-2 0v2a1 1 0 002 0V9zm-4 1a1 1 0 00-1-1H7a1 1 0 000 2h6a1 1 0 001-1z" clip-rule="evenodd" />
                        </svg>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>



        <script>
            // Wait for the DOM to be ready
            document.addEventListener("DOMContentLoaded", function() {
                // Select the flash message
                var flashMessage = document.getElementById('flash-message');

                // If there's a flash message, set a timer to remove it after 5 seconds
                if (flashMessage) {
                    setTimeout(function() {
                        flashMessage.style.transition = "opacity 0.5s ease-out";
                        flashMessage.style.opacity = "0";

                        setTimeout(function() {
                            flashMessage.remove();
                        }, 500); // Ensure the message is removed after the fade-out transition
                    }, 5000); // 5 seconds delay
                }
            });
        </script>


    <form method="POST" action="{{ route('myPage.show-update') }}">
        @csrf



          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Row 1 -->

            <div class="space-y-2">
              <label for="employee_number" class="block text-sm font-medium text-gray-700">社員番号</label>
              <input
              value="{{ $user->employer_id }}" readonly
              type="text" id="employee_number" name="employee_number" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="space-y-2">
              <label for="name" class="block text-sm font-medium text-gray-700">社員氏名</label>
              <input
                value="{{ $user->name }}"
              type="text" id="name" name="name" placeholder="姓と名の間に全角スペース" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="space-y-2">
              <label for="furigana" class="block text-sm font-medium text-gray-700">氏名フリガナ</label>
              <input
                  value="{{ $user->furigana }}"
              type="text" id="furigana" name="furigana" placeholder="姓と名の間に半角スペース" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

         <div class="space-y-2">
              <label for="previous_name" class="block text-sm font-medium text-gray-700">旧姓</label>

              <input
                  value="{{ old('previous_name', $user->userDetail->previous_name ?? '') }}"
              type="text" id="previous_name" name="previous_name" placeholder="漢字（該当者のみ）" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <!-- Row 2 -->
            <div class="space-y-2">
              <label for="gender" class="block text-sm font-medium text-gray-700">性別</label>
              <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option>選択</option>
                <option {{ old('gender', $user->gender) == '男性' ? 'selected' : '' }}>男性</option>
                <option {{ old('gender', $user->gender) == '女性' ? 'selected' : '' }}>女性</option>

              </select>
            </div>

            <div class="space-y-2">
              <label for="birth_date" class="block text-sm font-medium text-gray-700">生年月日</label>
              <input
                  value="{{ $user->birthdate }}"

              type="date" id="birth_date" name="birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="space-y-2">
              <label for="post_number" class="block text-sm font-medium text-gray-700">郵便番号</label>
              <input
              value="{{ $user->post_number }}"

              type="text" id="post_number" name="post_number" placeholder="514-1133" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

           <div class="space-y-2">
              <label for="address" class="block text-sm font-medium text-gray-700">住所</label>
              <input
              value="{{ $user->address }}"
              type="text" id="address" name="address" placeholder="三重県津市久居万町６９４番地３" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>


            <div class="space-y-2">
              <label for="phone_number" class="block text-sm font-medium text-gray-700">電話番号</label>
              <input
              value="{{ old('phone_number', $user->userDetail->phone_number ?? '') }}"

              type="text" id="phone_number" name="phone_number" placeholder="0596-55-3098" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>


            <div class="space-y-2">
              <label for="mobile_number" class="block text-sm font-medium text-gray-700">携帯電話</label>
              <input
                   value="{{ old('mobile_number', $user->userDetail->mobile_number ?? '') }}"

              type="tel" id="mobile_number" name="mobile_number" placeholder="090-2946-5123" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="space-y-2">
              <label for="email" class="block text-sm font-medium text-gray-700">Eメール</label>
              <input
                 value="{{ $user->email }}" readonly
              type="email" id="email" name="email" placeholder="会社メールを入れる" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="space-y-2">
              <label for="mobile_email" class="block text-sm font-medium text-gray-700">携帯メール</label>
              <input
              value="{{ old('mobile_email', $user->userDetail->mobile_email ?? '') }}"

              mobile_email
              type="email" id="mobile_email" name="mobile_email" placeholder="会社メールを入れる" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <!-- Row 4 -->
            <div class="space-y-2">
                <label for="driver_license" class="block text-sm font-medium text-gray-700">運転免許の有無</label>
                <select id="driver_license" name="driver_license" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option>選択</option>
                    <option {{ old('driver_license', optional($user->userDetail)->driver_license) == '有' ? 'selected' : ''}}>有</option>
                    <option {{ old('driver_license', optional($user->userDetail)->driver_license) == '無' ? 'selected' : ''}}>無</option>
                </select>
            </div>

            <div class="space-y-2">
                <label for="employed_date" class="block text-sm font-medium text-gray-700">入社日</label>
                <input
                value="{{ old('employed_date', $user->userDetail->employed_date ?? '') }}" readonly

                type="date" id="employed_date" name="employed_date" placeholder="0596-55-3098" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>


            <div class="space-y-2">
                <label for="household_name" class="block text-sm font-medium text-gray-700">世帯主：氏名</label>
                <input
                value="{{ old('household_name', $user->userDetail->household_name ?? '') }}"

                type="text" id="employed_date" name="employed_date" placeholder="0596-55-3098" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="space-y-2">
                <label for="household_relation" class="block text-sm font-medium text-gray-700">世帯主：続柄</label>
                <input
                value="{{ old('household_relation', $user->userDetail->household_relation ?? '') }}"

                type="text" id="household_relation" name="household_relation" placeholder="本人，配偶者，父" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>


            <div class="space-y-2">
                <label for="pension_number" class="block text-sm font-medium text-gray-700">基礎年金番号</label>
                <input

            value="{{ old('pension_number', $user->userDetail->pension_number ?? '') }}" readonly

                type="text" id="pension_number" name="pension_number" placeholder="本人，配偶者，父" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>


            <div class="space-y-2">
                <label for="oneway_comute_distance" class="block text-sm font-medium text-gray-700">片道通勤距離</label>
                <input

                value="{{ old('oneway_comute_distance', $user->userDetail->oneway_comute_distance ?? '') }}"


                type="text" id="oneway_comute_distance" name="oneway_comute_distance" placeholder="123" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
          </div>



          <div class="flex justify-between mt-4">
            <x-button purpose="default" type="" href="{{ route('myPage.index') }}" >
                戻り
            </x-button>
            <x-button purpose="search" type="submit" >
                保存
            </x-button>
        </div>


        </form>
    </div>
    </div>

</x-app-layout>








