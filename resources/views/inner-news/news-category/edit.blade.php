<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-t-xl shadow-lg ">
                <div class="p-6 text-center md:text-left">
                    <h1 class="text-2xl font-extrabold text-white mb-2">社内回覧カテゴリー管理</h1>
                    <h3 class="text-xl font-semibold text-white mb-2">編集</h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('inner-news.news-category.update', $newsCategory) }}" id="categoryForm">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">カテゴリ名</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   value="{{ old('name', $newsCategory->name) }}"
                                   required />
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">内容</label>
                            <div id="fields-container">
                                <!-- Fields will be added here dynamically -->
                            </div>

                        </div>

                        <!-- Hidden input to store JSON -->
                        <input type="hidden" name="fields" id="fields-json">

                        <div class="flex justify-between">

                            <div>
                                <button type="button"
                                onclick="addField()"
                                class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>


                                </button>



                            </div>

                            <div>
                                <a href="{{ route('inner-news.news-category.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 mr-5 text-xs">
                                キャンセル
                            </a>


                             <button type="submit"
                                onclick="prepareSubmit(event)"
                                class="mt-6 inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                           保存する
                           </button>

                            </div>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let fieldCount = 0;
        const existingFields = @json($newsCategory->fields);

        function addField(field = null) {
            const container = document.getElementById('fields-container');
            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'field-group bg-gray-50 p-4 rounded-md mb-4 border border-gray-300 ';
            fieldDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">フィールド名</label>
                        <input type="text"
                               class="field-name mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="${field ? field.name : ''}"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">データ型</label>
                        <select class="field-type mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="text" ${field && field.type === 'text' ? 'selected' : ''}>テキスト</option>
                            <option value="number" ${field && field.type === 'number' ? 'selected' : ''}>数字</option>
                            <option value="date" ${field && field.type === 'date' ? 'selected' : ''}>日付</option>
                            <option value="email" ${field && field.type === 'email' ? 'selected' : ''}>メール</option>
                            <option value="textarea" ${field && field.type === 'textarea' ? 'selected' : ''}>長いテキスト</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="field-required rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               ${field && field.required ? 'checked' : ''}>
                        <span class="ml-2 text-sm text-gray-600">Required field</span>
                    </label>

                 <button type="button"
                            onclick="this.parentElement.parentElement.remove()"
                            class="flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg ml-auto">

                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M9 3h6m-6 0a1 1 0 00-1 1v1h8V4a1 1 0 00-1-1h-6z" />
                                </svg>
                            取り除く
                    </button>
                </div>
            `;
            container.appendChild(fieldDiv);
            fieldCount++;
        }

        function prepareSubmit(event) {
            event.preventDefault();
            const fields = [];
            const fieldGroups = document.getElementsByClassName('field-group');

            for (const group of fieldGroups) {
                fields.push({
                    name: group.querySelector('.field-name').value,
                    // label: group.querySelector('.field-label').value,
                    type: group.querySelector('.field-type').value,
                    required: group.querySelector('.field-required').checked
                });
            }

            document.getElementById('fields-json').value = JSON.stringify(fields);
            document.getElementById('categoryForm').submit();
        }

        // Load existing fields
        document.addEventListener('DOMContentLoaded', function() {
            if (existingFields.length > 0) {
                existingFields.forEach(field => addField(field));
            } else {
                addField();
            }
        });
    </script>
</x-app-layout>
