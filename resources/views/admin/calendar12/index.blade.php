@extends('admin.dashboard')

@section('admin')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
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
