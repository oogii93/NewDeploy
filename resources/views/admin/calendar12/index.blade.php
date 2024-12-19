@extends('admin.dashboard')

@section('admin')

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
    <div class="py-20 bg-gray-100 shadow-sm min-h-screen">
        <div class="bg-white p-4 rounded-lg shadow-lg w-96 mx-auto">
            <h2 class="text-xl font-semibold mt-2 mb-4 text-center">12か月カレンダー</h2>
            <form action="{{ route('admin.calendar12.show') }}" method="POST">
                @csrf
                <div>
                    <label for="corps_id" class="block mb-2">会社を選択してください</label>
                    <select name="corps_id" id="corps_id" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        <option value="">会社</option>
                        @foreach($corps as $corp)
                            <option value="{{ $corp->id }}">{{ $corp->corp_name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="mt-4">
                    <label for="office_id" class="block mb-2">所属を選択してください</label>
                    <select name="office_id" id="office_id" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        <option value="">所属</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="mt-4">
                    <label for="year" class="block mb-2">年を選択してください</label>
                    <select name="year" id="year" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        @for ($i = date('Y'); $i <= date('Y') +5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mt-4">
                    <x-button purpose="search" type="submit">
                            検索
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
