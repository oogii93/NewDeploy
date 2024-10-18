<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-12">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">






                <div class="px-6 py-8">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">名刺注文表</h1>




                    <div class="bg-sky-100 p-6 rounded-lg mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">会社</label>
                                <input type="text" id="corp" name="corp" value="{{ $form->corp }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">営業所</label>
                                <input type="text" id="office" name="office" value="{{ $form->office }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">所属</label>
                                <input type="text" id="division" name="division" value="{{ $form->division }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">氏名</label>
                                <input type="text" id="name" name="name" value="{{ $form->name }}" class="w-full  text-gray-800 border-1 rounded-md p-2" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="piece" class="block text-sm font-semibold text-gray-700 mb-1">名刺数量</label>
                        <input type="number" id="piece" name="piece" value="{{ $form->piece }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="１００枚が一箱になります。" readonly>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center space-x-4 mb-2">
                            <label class="inline-flex items-center">
                                <input type="radio"
                                       name="change_status"
                                       value="change_status"
                                       class="form-radio text-teal-600"
                                       onclick="toggleInput('show')"
                                       {{ $form->change_status === 'change_status' ? 'checked' : '' }}
                                       readonly>
                                <span class="ml-2">変更有</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio"
                                       name="change_status"
                                       value="no_change"
                                       class="form-radio text-teal-600"
                                       onclick="toggleInput('hide')"
                                       {{ $form->change_status === 'no_change' ? 'checked' : '' }}
                                       readonly>
                                <span class="ml-2">変更無</span>
                            </label>
                        </div>
                        <div id="textInputContainer" class="{{ $form->change_status === 'change_status' ? '' : 'hidden' }} mt-3">
                            <label for="textInput" class="block text-sm font-medium text-gray-700 mb-1">変更内容</label>
                            <input type="text"
                                   id="change_details"
                                   name="change_details"
                                   value="{{ $form->change_details }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                                   readonly>
                        </div>
                    </div>




                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-semibold text-gray-700 mb-1">コメント</label>
                        <textarea id="comment" name="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="内容" readonly>{{ $form->comment }}</textarea>
                    </div>

                    <div class="flex justify-between mt-4">
                        <x-button purpose="default" type="" href="{{route('applications2.index')}}" >
                            戻り
                        </x-button>
                
                    </div>



                </div>
              



            </div>
        
        </div>
       
      
    </div>
    <script>
        function toggleInput(action) {
            var inputContainer = document.getElementById('textInputContainer');
            if (!document.querySelector('input[name="change_status"]').hasAttribute('readonly')) {
                inputContainer.classList.toggle('hidden', action === 'hide');
            }
        }

        // Initial state setup
        document.addEventListener('DOMContentLoaded', function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('request_date').value = today;

            // Show/hide change details based on stored value
            var changeStatus = '{{ $form->change_status }}';
            var inputContainer = document.getElementById('textInputContainer');
            inputContainer.classList.toggle('hidden', changeStatus !== 'change_status');
        });
    </script>


</x-app-layout>
