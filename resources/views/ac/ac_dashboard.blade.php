<x-app-layout>
    @if (session('success') || session('error'))
    <div id="statusToast" class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
        <div class="bg-white border-l-4 @if(session('success')) border-blue-500 @else border-red-500 @endif rounded-r-lg shadow-md overflow-hidden">
            <div class="p-4 flex items-center">
                <div class="flex-shrink-0">
                    @if (session('success'))
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                <div class="ml-3 w-0 flex-1">
                    @if (session('success'))
                        <p class="text-lg font-semibold text-blue-900">
                            {!! session('success') !!}
                        </p>
                    @endif
                    @if (session('error'))
                        <p class="text-sm font-medium text-gray-900">
                            {{ session('error') }}
                        </p>
                    @endif


                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="closeToast" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    閉じる
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideDown {
            from { transform: translate(-50%, -100%); }
            to { transform: translate(-50%, 0); }
        }
        #statusToast {
            animation: slideDown 0.5s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusToast = document.getElementById('statusToast');
            var closeToast = document.getElementById('closeToast');

            var hideTimeout = setTimeout(function() {
                hideToast();
            }, 8000);

            closeToast.addEventListener('click', function() {
                clearTimeout(hideTimeout);
                hideToast();
            });

            function hideToast() {
                statusToast.style.transform = 'translate(-50%, -100%)';
                statusToast.style.transition = 'transform 0.5s ease-in-out';
                setTimeout(function() {
                    statusToast.style.display = 'none';
                }, 500);
            }
        });
    </script>
@endif
 <div class="min-h-screen bg-gray-100">
    <div class="bg-white container mx-auto mt-5 rounded-xl">


    <div class="container mx-auto ">
        {{-- Page Header --}}
        <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-t-xl shadow-lg mb-8">
            <div class="p-6 text-center md:text-left">
                <h1 class="text-4xl font-extrabold text-white mb-2">経理課画面</h1>
                <p class="text-sky-100 text-lg">確認済み申請書</p>
            </div>
        </div>
        <div class="px-1 py-3 bg-white border-2 border-indigo-200 w-full md:w-3/5 mx-auto">
            <div class="py-2 px-5" x-data="applicationSearch()" x-init="init()">
                <form @submit.prevent="search" class="mb-4">
                    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                        <input type="text" x-model="searchTerm" placeholder="検索入力" class="border rounded px-2 py-1 w-full md:w-auto">
                        <input type="date" x-model="fromDate" class="border rounded px-2 py-1 w-full md:w-auto">
                        <input type="date" x-model="toDate" class="border rounded px-2 py-1 w-full md:w-auto">
                        <x-button purpose="submit" type="submit">
                            検索
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="applications-table">
        @include('ac.ac_table', ['applications' => $applications])
    </div>
</div>
</div>


    <script>
    function applicationSearch() {
        return {
            searchTerm: '',
            fromDate: '',
            toDate: '',
            init() {
                // Initial load is handled by the server
            },
            search() {
                fetch(`/applications/boss?search=${this.searchTerm}&from_date=${this.fromDate}&to_date=${this.toDate}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('applications-table').innerHTML = html;
                });
            }
        }
    }
    </script>
</x-app-layout>
