<x-app-layout>
    <div class="py-5 px-1">


        <h1 class="font-bold text-2xl">

        人事課画面
        </h1>
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
        @include('hr.hr_table', ['applications' => $applications])
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
