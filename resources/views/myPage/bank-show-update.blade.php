<x-app-layout>

    <div class="max-w-6xl mx-auto p-8 bg-white shadow-lg rounded-xl mt-10">

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



        <h2 class="text-center text-2xl font-semibold text-blue-600 mb-4">{{ $user->name }} さんの銀行情報</h2>

        <p class="text-lg text-gray-600 mb-6 text-center font-semibold">銀行振り込み基本情報</p>



        <form action="{{ route('myPage.bank-show-update') }}" method="POST">
            @csrf

            <!-- Employee Information Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div>
                    <label for="employee_number" class="block text-sm font-medium text-gray-700 mb-2">社員番号</label>
                    <div class="block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm bg-gray-100">
                        {{ $user->employer_id }}
                     </div>
                </div>
                <div>
                    <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-2">会社名</label>
                    <div class="block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm bg-gray-100">
                        {{ $user->corp->corp_name }}
                     </div>
                </div>
                <div>
                    <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-2">営業所名</label>
                    <div class="block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm bg-gray-100">
                        {{ $user->office->office_name }}
                     </div>
                </div>
                <div>
                    <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-2">社員氏名</label>
                    <div class="block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm bg-gray-100">
                        {{ $user->name }}
                     </div>
                </div>
            </div>

            <h2 class="text-center text-xl font-semibold text-blue-600 mb-4 mt-5">銀行1</h2>

            <!-- Bank Information Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div>
                    <label for="salary_bank_order_1" class="block text-sm font-medium text-gray-700 mb-2">給与：優先順位１</label>
                    <input type="number" id="salary_bank_order_1" name="salary_bank_order_1" placeholder="1"

                    value="{{ old('salary_bank_order_1', $user->userBankDetail->salary_bank_order_1 ?? '') }}"
                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_payment_method_1" class="block text-sm font-medium text-gray-700 mb-2">給与：支給方法１</label>
                    <select id="salary_payment_method_1" name="salary_payment_method_1" required
                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                        <option value="">選択</option>
                        <option value="銀行振込" {{ (old('salary_payment_method_1', $user->userBankDetail->salary_payment_method_1 ?? '') =='銀行振込') ? 'selected' : '' }}>銀行振込</option>
                    </select>
                </div>

                <div>
                    <label for="salary_payment_type1" class="block text-sm font-medium text-gray-700 mb-2">給与：支給区分１</label>
                    <select id="salary_payment_type1" name="salary_payment_type1" required
                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                        <option value="">選択</option>
                        <option value="全額" {{ (old('salary_payment_type1', $user->userBankDetail->salary_payment_type1 ?? '') =='全額') ? 'selected' : '' }}>全額</option>
                        <option value="定額" {{ (old('salary_payment_type1', $user->userBankDetail->salary_payment_type1 ?? '') =='定額') ? 'selected' : '' }}>定額</option>
                        <option value="残額" {{ (old('salary_payment_type1', $user->userBankDetail->salary_payment_type1 ?? '') =='残額') ? 'selected' : '' }}>残額</option>
                    </select>
                </div>

                <div>
                    <label for="salary_payment_amount1" class="block text-sm font-medium text-gray-700 mb-2">給与：支給金額１</label>
                    <input type="number" id="salary_payment_amount1" name="salary_payment_amount1" placeholder="1"
                    value="{{ old('salary_payment_amount1', $user->userBankDetail->salary_payment_amount1 ?? '') }}"
                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>


                <div>
                    <label for="salary_bank1" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：銀行１</label>
                    <input type="text" id="salary_bank1" name="salary_bank1" placeholder="1"
                       value="{{ old('salary_bank1', $user->userBankDetail->salary_bank1 ?? '') }}"
                    class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>


                <div>
                    <label for="salary_bank_branch1" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支店１</label>
                    <input type="text" id="salary_bank_branch1" name="salary_bank_branch1" placeholder="1"

                    value="{{ old('salary_bank_branch1', $user->userBankDetail->salary_bank_branch1 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_account_type1" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：預金種目１</label>
                    <select name="salary_account_type1" id="salary_account_type1" required
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="普通" {{ (old('salary_account_type1', $user->userBankDetail->salary_account_type1 ?? '') =='普通') ? 'selected' : '' }}>普通</option>

                    </select>
                </div>


                <div>
                    <label for="salary_account_address1" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：口座番号１</label>
                    <input type="number" id="salary_account_address1" name="salary_account_address1" placeholder="口座番号：4680000"
                    value="{{ old('salary_account_address1', $user->userBankDetail->salary_account_address1 ?? '') }}"
                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>


            <!--2dohi banknii-->
            <h2 class="text-center text-xl font-semibold text-blue-600 mb-4 mt-5">銀行2</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label for="salary_bank_order_2" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：優先順位2</label>
                    <input type="number" id="salary_bank_order_2" name="salary_bank_order_2" placeholder="2"
                    value="{{ old('salary_bank_order_2', $user->userBankDetail->salary_bank_order_2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>



                <div>
                    <label for="salary_payment_method_2" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支給方法2</label>
                    <select name="salary_payment_method_2" id="salary_payment_method_2"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="銀行振込" {{ (old('salary_payment_method_2', $user->userBankDetail->salary_payment_method_2 ?? '') =='銀行振込') ? 'selected' : '' }}>銀行振込</option>

                    </select>
                </div>

                <div>
                    <label for="salary_payment_type2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支給区分2</label>
                    <select name="salary_payment_type2" id="salary_payment_type2"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="全額" {{ (old('salary_payment_type2', $user->userBankDetail->salary_payment_type2 ?? '') =='全額') ? 'selected' : '' }}>全額</option>
                        <option value="定額" {{ (old('salary_payment_type2', $user->userBankDetail->salary_payment_type2 ?? '') =='定額') ? 'selected' : '' }}>定額</option>
                        <option value="残額" {{ (old('salary_payment_type2', $user->userBankDetail->salary_payment_type2 ?? '') =='残額') ? 'selected' : '' }}>残額</option>

                    </select>
                </div>

                <div>
                    <label for="salary_payment_amount2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与:支給金額2</label>
                    <input type="number" id="salary_payment_amount2" name="salary_payment_amount2" placeholder="1"
                    value="{{ old('salary_payment_amount2', $user->userBankDetail->salary_payment_amount2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_bank2" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与:銀行2</label>
                    <input type="text" id="salary_bank2" name="salary_bank2" placeholder="1"
                    value="{{ old('salary_bank2', $user->userBankDetail->salary_bank2 ?? '') }}"

                    class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_bank_branch2" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与:支店2</label>
                    <input type="text" id="salary_bank_branch2" name="salary_bank_branch2" placeholder="1"
                    value="{{ old('salary_bank_branch2', $user->userBankDetail->salary_bank_branch2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_account_type2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与:預金種目2</label>
                    <select name="salary_account_type2" id="salary_account_type2"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="普通" {{ (old('salary_account_type2', $user->userBankDetail->salary_account_type2 ?? '') =='普通') ? 'selected' : '' }}>普通</option>

                    </select>
                </div>


                <div>
                    <label for="salary_account_address2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：口座番号2</label>
                    <input type="number" id="salary_account_address2" name="salary_account_address2" placeholder="口座番号：4681933"

                    value="{{ old('salary_account_address2', $user->userBankDetail->salary_account_address2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>


            <!--3dohi banknii-->
            <h2 class="text-center text-xl font-semibold text-blue-600 mb-4 mt-5">銀行3</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label for="salary_bank_order_3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：優先順位3</label>
                    <input type="number" id="salary_bank_order_3" name="salary_bank_order_3" placeholder="1"
                    value="{{ old('salary_bank_order_3', $user->userBankDetail->salary_bank_order_3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>



                <div>
                    <label for="salary_payment_method_3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支給方法3</label>
                    <select name="salary_payment_method_3" id="salary_payment_method_3"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="銀行振込" {{ (old('salary_payment_method_3', $user->userBankDetail->salary_payment_method_3 ?? '') =='銀行振込') ? 'selected' : '' }}>銀行振込</option>

                    </select>
                </div>

                <div>
                    <label for="salary_payment_type3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支給区分3</label>
                    <select name="salary_payment_type3" id="salary_payment_type3"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="全額" {{ (old('salary_payment_type3', $user->userBankDetail->salary_payment_type3 ?? '') =='全額') ? 'selected' : '' }}>全額</option>
                        <option value="定額" {{ (old('salary_payment_type3', $user->userBankDetail->salary_payment_type3 ?? '') =='定額') ? 'selected' : '' }}>定額</option>
                        <option value="残額" {{ (old('salary_payment_type3', $user->userBankDetail->salary_payment_type3 ?? '') =='残額') ? 'selected' : '' }}>残額</option>

                    </select>
                </div>

                <div>
                    <label for="salary_payment_amount3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支給金額3</label>
                    <input type="number" id="salary_payment_amount3" name="salary_payment_amount3" placeholder="1"
                    value="{{ old('salary_payment_amount3', $user->userBankDetail->salary_payment_amount3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_bank3" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：銀行3</label>
                    <input type="text" id="salary_bank3" name="salary_bank3" placeholder="1"
                    value="{{ old('salary_bank3', $user->userBankDetail->salary_bank3 ?? '') }}"

                    class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>


                <div>
                    <label for="salary_bank_branch3" class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：支店3</label>
                    <input type="text" id="salary_bank_branch3" name="salary_bank_branch3" placeholder="1"
                    value="{{ old('salary_bank_branch3', $user->userBankDetail->salary_bank_branch3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="salary_account_type3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：預金種目3</label>
                    <select name="salary_account_type3" id="salary_account_type3"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="普通" {{ (old('salary_account_type3', $user->userBankDetail->salary_account_type3 ?? '') =='普通') ? 'selected' : '' }}>普通</option>

                    </select>
                </div>


                <div>
                    <label for="salary_account_address3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">給与：口座番号3</label>
                    <input type="number" id="salary_account_address3" name="salary_account_address3" placeholder="口座番号：4681933"
                    value="{{ old('salary_account_address3', $user->userBankDetail->salary_account_address3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>



            <!--1dohi shagnal banknii-->
            <h2 class="text-center text-xl font-semibold text-blue-600 mb-4 mt-5">賞与銀行1</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">


                <div>
                    <label for="bonus_bank_order_1"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：優先順位１</label>
                    <input type="number" id="bonus_bank_order_1" name="bonus_bank_order_1" placeholder="1"
                    value="{{ old('bonus_bank_order_1', $user->userBankDetail->bonus_bank_order_1 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>



                <div>
                    <label for="bonus_payment_method_1"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給方法１</label>
                    <select name="bonus_payment_method_1" id="bonus_payment_method_1"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="銀行振込" {{ (old('bonus_payment_method_1', $user->userBankDetail->bonus_payment_method_1 ?? '') =='銀行振込') ? 'selected' : '' }}>銀行振込</option>

                    </select>
                </div>

                <div>
                    <label for="bonus_payment_type1"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給区分１</label>
                    <select name="bonus_payment_type1" id="bonus_payment_type1"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="全額" {{ (old('bonus_payment_type1', $user->userBankDetail->bonus_payment_type1 ?? '') =='全額') ? 'selected' : '' }}>全額</option>
                        <option value="定額" {{ (old('bonus_payment_type1', $user->userBankDetail->bonus_payment_type1 ?? '') =='定額') ? 'selected' : '' }}>定額</option>
                        <option value="残額" {{ (old('bonus_payment_type1', $user->userBankDetail->bonus_payment_type1 ?? '') =='残額') ? 'selected' : '' }}>残額</option>

                    </select>
                </div>

                <div>
                    <label for="bonus_payment_amount1"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給金額１</label>
                    <input type="number" id="bonus_payment_amount1" name="bonus_payment_amount1" placeholder="1"
                    value="{{ old('bonus_payment_amount1', $user->userBankDetail->bonus_payment_amount1 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_bank1" class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：銀行１</label>
                    <input type="text" id="bonus_bank1" name="bonus_bank1" placeholder="105銀行"
                    value="{{ old('bonus_bank1', $user->userBankDetail->bonus_bank1 ?? '') }}"

                    class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

                <div>
                    <label for="bonus_bank_branch1" class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支店１</label>
                    <input type="text" id="bonus_bank_branch1" name="bonus_bank_branch1" placeholder="1"
                    value="{{ old('bonus_bank_branch1', $user->userBankDetail->bonus_bank_branch1 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_account_type1"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：預金種目１</label>
                    <select name="bonus_account_type1" id="bonus_account_type1"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="普通" {{ (old('bonus_account_type1', $user->userBankDetail->bonus_account_type1 ?? '') =='普通') ? 'selected' : '' }}>普通</option>

                    </select>
                </div>


                <div>
                    <label for="bonus_account_address1"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：口座番号１</label>
                    <input type="number" id="bonus_account_address1" name="bonus_account_address1" placeholder="口座番号：4681933"
                    value="{{ old('bonus_account_address1', $user->userBankDetail->bonus_account_address1 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>
            <!--2dohi shagnal banknii-->
            <h2 class="text-center text-xl font-semibold text-blue-600 mb-4 mt-5">賞与銀行2</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label for="bonus_bank_order_2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：優先順位２</label>
                    <input type="number" id="bonus_bank_order_2" name="bonus_bank_order_2" placeholder="1"
                    value="{{ old('bonus_bank_order_2', $user->userBankDetail->bonus_bank_order_2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>



                <div>
                    <label for="bonus_payment_method_2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給方法２</label>
                    <select name="bonus_payment_method_2" id="bonus_payment_method_2"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="銀行振込" {{ (old('bonus_payment_method_2', $user->userBankDetail->bonus_payment_method_2 ?? '') =='銀行振込') ? 'selected' : '' }}>銀行振込</option>

                    </select>
                </div>

                <div>
                    <label for="bonus_payment_type2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給区分２</label>
                    <select name="bonus_payment_type2" id="bonus_payment_type2"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="全額" {{ (old('bonus_payment_type2', $user->userBankDetail->bonus_payment_type2 ?? '') =='全額') ? 'selected' : '' }}>全額</option>
                        <option value="定額" {{ (old('bonus_payment_type2', $user->userBankDetail->bonus_payment_type2 ?? '') =='定額') ? 'selected' : '' }}>定額</option>
                        <option value="残額" {{ (old('bonus_payment_type2', $user->userBankDetail->bonus_payment_type2 ?? '') =='残額') ? 'selected' : '' }}>残額</option>

                    </select>
                </div>

                <div>
                    <label for="bonus_payment_amount2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給金額2</label>
                    <input type="number" id="bonus_payment_amount2" name="bonus_payment_amount2" placeholder="1"
                    value="{{ old('bonus_payment_amount2', $user->userBankDetail->bonus_payment_amount2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_bank2" class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：銀行2</label>
                    <input type="text" id="bonus_bank2" name="bonus_bank2" placeholder="105銀行"
                    value="{{ old('bonus_bank2', $user->userBankDetail->bonus_bank2 ?? '') }}"

                    class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_bank_branch2" class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支店2</label>
                    <input type="text" id="bonus_bank_branch2" name="bonus_bank_branch2" placeholder="1"

                    value="{{ old('bonus_bank_branch2', $user->userBankDetail->bonus_bank_branch2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_account_type2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：預金種目2</label>
                    <select name="bonus_account_type2" id="bonus_account_type2"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="普通" {{ (old('bonus_account_type2', $user->userBankDetail->bonus_account_type2 ?? '') =='普通') ? 'selected' : '' }}>普通</option>

                    </select>
                </div>


                <div>
                    <label for="bonus_account_address2"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：口座番号2</label>
                    <input type="number" id="bonus_account_address2" name="bonus_account_address2" placeholder="口座番号：4681933"
                    value="{{ old('bonus_account_address2', $user->userBankDetail->bonus_account_address2 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>
            <!--3dohi shagnal banknii-->
            <h2 class="text-center text-xl font-semibold text-blue-600 mb-4 mt-5">賞与銀行3</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label for="bonus_bank_order_3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：優先順位3</label>
                    <input type="number" id="bonus_bank_order_3" name="bonus_bank_order_3" placeholder="1"
                    value="{{ old('bonus_bank_order_3', $user->userBankDetail->bonus_bank_order_3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>



                <div>
                    <label for="bonus_payment_method_3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給方法3</label>
                    <select name="bonus_payment_method_3" id="bonus_payment_method_3"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="銀行振込" {{ (old('bonus_payment_method_3', $user->userBankDetail->bonus_payment_method_3 ?? '') =='銀行振込') ? 'selected' : '' }}>銀行振込</option>


                    </select>
                </div>

                <div>
                    <label for="bonus_payment_type3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給区分3</label>
                    <select name="bonus_payment_type3" id="bonus_payment_type3"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="全額" {{ (old('bonus_payment_type3', $user->userBankDetail->bonus_payment_type3 ?? '') =='全額') ? 'selected' : '' }}>全額</option>
                        <option value="定額" {{ (old('bonus_payment_type3', $user->userBankDetail->bonus_payment_type3 ?? '') =='定額') ? 'selected' : '' }}>定額</option>
                        <option value="残額" {{ (old('bonus_payment_type3', $user->userBankDetail->bonus_payment_type3 ?? '') =='残額') ? 'selected' : '' }}>残額</option>

                    </select>
                </div>

                <div>
                    <label for="bonus_payment_amount3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支給金額3</label>
                    <input type="number" id="bonus_payment_amount3" name="bonus_payment_amount3" placeholder="1"
                    value="{{ old('bonus_payment_amount3', $user->userBankDetail->bonus_payment_amount3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_bank3" class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：銀行3</label>
                    <input type="text" id="bonus_bank3" name="bonus_bank3" placeholder="105銀行"
                    value="{{ old('bonus_bank3', $user->userBankDetail->bonus_bank3 ?? '') }}"

                    class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

                <div>
                    <label for="bonus_bank_branch3" class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：支店3</label>
                    <input type="text" id="bonus_bank_branch3" name="bonus_bank_branch3" placeholder="1"

                    value="{{ old('bonus_bank_branch3', $user->userBankDetail->bonus_bank_branch3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="bonus_account_type3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：預金種目3</label>
                    <select name="bonus_account_type3" id="bonus_account_type3"
                        class="form-select block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out appearance-none">
                        <option value="">選択</option>
                        <option value="普通"  {{ (old('bonus_account_type3', $user->userBankDetail->bonus_account_type3 ?? '') =='普通') ? 'selected' : '' }}>普通</option>

                    </select>
                </div>


                <div>
                    <label for="bonus_account_address3"
                        class="block text-sm font-medium text-gray-700 mb-1 py-2">賞与：口座番号3</label>
                    <input type="number" id="bonus_account_address3" name="bonus_account_address3" placeholder="口座番号：4681933"

                    value="{{ old('bonus_account_address3', $user->userBankDetail->bonus_account_address3 ?? '') }}"

                        class="form-input mt-1 block w-full px-3 py-2 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
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



</x-app-layout>
