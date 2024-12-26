<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto mt-5">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-t-xl shadow-lg mb-8">
                    <div class="p-6">
                        <h1 class="text-4xl font-extrabold text-white mb-2">社内回覧</h1>
                        <p class="text-sky-100 text-lg">社内ニュースの編集</p>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('inner-news.update', $innerNews->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $innerNews->title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-400 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">内容</label>
                            <textarea name="content" id="content" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-400 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                                      placeholder="">{{ old('content', $innerNews->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="categories-container" class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">選択</h3>
                            </div>
                        </div>

                        <div class="flex justify-between space-x-4">
                            <div class="">
                                <button type="button" onclick="addCategory()"
                                    class="flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <div class="">
                                <a href="{{ route('inner-news.index') }}"
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 mr-5">
                                    キャンセル
                                </a>
                                <button type="submit"
                                        class="bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                    更新する
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const categories = @json($categories);
        const existingCategoriesData = @json($innerNews->categories_data);
        let categoryCounter = 0;

        function addCategory(existingData = null) {
            const container = document.getElementById('categories-container');
            const categoryDiv = document.createElement('div');
            categoryDiv.className = 'border border-gray-400 rounded-lg p-4 relative';
            categoryDiv.id = `category-section-${categoryCounter}`;

            const selectHtml = `
                <div class="flex justify-between items-center mb-4">
                    <select name="categories_data[${categoryCounter}][category_id]"
                            onchange="loadCategoryFields(this, ${categoryCounter})"
                            class="w-1/4 rounded-md border-blue-400 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        <option value="">選択してください。</option>
                        ${categories.map(cat => `<option value="${cat.id}" ${existingData && existingData.category_id == cat.id ? 'selected' : ''}>${cat.name}</option>`).join('')}
                    </select>
                    <button type="button" onclick="removeCategory(${categoryCounter})"
                        class="flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M9 3h6m-6 0a1 1 0 00-1 1v1h8V4a1 1 0 00-1-1h-6z" />
                        </svg>
                        取り除く
                    </button>
                </div>
                <div id="fields-${categoryCounter}"></div>
            `;

            categoryDiv.innerHTML = selectHtml;
            container.appendChild(categoryDiv);

            if (existingData) {
                const select = categoryDiv.querySelector('select');
                loadCategoryFields(select, categoryCounter, existingData.fields);
            }

            categoryCounter++;
        }

        function removeCategory(index) {
            const categorySection = document.getElementById(`category-section-${index}`);
            categorySection.remove();
        }

        function loadCategoryFields(selectElement, index, existingFields = null) {
            const categoryId = selectElement.value;
            const category = categories.find(cat => cat.id == categoryId);
            const fieldsContainer = document.getElementById(`fields-${index}`);

            if (!category) {
                fieldsContainer.innerHTML = '';
                return;
            }

            let fieldsHtml = '';
            category.fields.forEach(field => {
                const fieldName = `categories_data[${index}][fields][${field.name}]`;
                const fieldValue = existingFields ? existingFields[field.name] : '';
                fieldsHtml += `
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">
                            ${field.label || field.name}
                        </label>
                        ${
                            field.type === 'textarea'
                                ? `<textarea name="${fieldName}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                                            rows="3">${fieldValue}</textarea>`
                                : `<input type="${field.type || 'text'}"
                                        name="${fieldName}"
                                        value="${fieldValue}"
                                        class="mt-1 block w-full md:w-2/4 rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">`
                        }
                    </div>
                `;
            });

            fieldsContainer.innerHTML = fieldsHtml;
        }

        // Load existing categories on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (existingCategoriesData && existingCategoriesData.length > 0) {
                existingCategoriesData.forEach(categoryData => {
                    addCategory(categoryData);
                });
            } else {
                addCategory();
            }
        });
    </script>
</x-app-layout>
