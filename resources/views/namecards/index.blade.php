<x-app-layout>
    {{-- Flash Messages --}}
  {{-- Flash Messages --}}
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

    {{-- Main Container --}}
    <div class="container mx-auto px-4 py-8 md:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">名刺管理</h1>

                <div class="flex flex-col md:flex-row w-full md:w-auto space-y-2 md:space-y-0 md:space-x-2">
                    <x-button purpose="search" href="{{ route('namecards.create') }}" class="w-full md:w-auto">
                        新規登録
                    </x-button>
                </div>
            </div>

            {{-- Search Form --}}

            <div class="w-full max-w-md mt-10 ">
                <form action="{{ route('namecards.index') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="search"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="キーワードで検索..."
                        class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out shadow-sm hover:border-blue-400"
                    >
                    <button
                        type="submit"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-sky-600 rounded-r-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition duration-300 ease-in-out"
                    >
                        検索
                    </button>
                </form>
            </div>
        </div>

        {{-- Namecard Table --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-sky-200">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">会社名</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">画像</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">名刺名</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">電話番号</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nameCardData as $namecard)
                            <tr>
                                <td class="border border-gray-300 px-4 py-4">
                                    <div class="text-sm text-gray-900">{{ $namecard->company }}</div>
                                </td>


                                <td class="border border-gray-300 px-4 py-4 hidden md:table-cell ">
                                    @if($namecard->image_path)
                                        <img
                                            src="{{ Storage::url($namecard->image_path) }}"
                                            alt="Name Card"
                                            class="w-24 h-20 object-cover rounded-lg hover:scale-150 transform transition duration-300"
                                        >
                                    @else
                                        <div class="text-sm text-gray-500">No image</div>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">{{ $namecard->name }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">{{ $namecard->phone }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-4">
                                    <div class="text-sm text-gray-900">{{ $namecard->email }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-4">
                                    <div class="flex space-x-2 justify-center">
                                        <a
                                            href="{{ route('namecards.show', $namecard->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition duration-300"

                                            title="編集"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-.033.064-.066.129-.1.193-.826 1.61-2.385 3.39-4.748 4.807C14.307 18.723 12.79 19 12 19c-4.478 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                        </a>

                                        <a
                                        href="{{ route('namecards.edit', $namecard->id) }}"

                                                class="text-yellow-600 hover:text-yellow-900 transition duration-300"
                                        title="編集"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>

                                    </a>


                                        <form
                                            action="{{ route('namecards.destroy', $namecard->id) }}"
                                            method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('本当に消去しますか？')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-900 transition duration-300"
                                                title="消去"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $nameCardData->appends(request()->query())->links() }}

        </div>
    </div>

    {{-- Flash Message Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.classList.add('animate-fadeOut');
                    setTimeout(() => flashMessage.remove(), 500);
                }, 5000);
            }
        });
    script>
</x-app-layout>
