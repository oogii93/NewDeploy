@extends('admin.dashboard')

@section('admin')
<div class="py-20 bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-gray-700 text-center mb-6">給料計算CSV</h2>

        <form action="{{ route('admin.download1.csv') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="corps_id" class="block text-sm font-medium text-gray-600 mb-2">会社を選択してください</label>
                <select name="corps_id" id="corps_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition ease-in-out duration-300">
                    <option value="">会社</option>
                    @foreach ($corps as $corp)
                        <option value="{{ $corp->id }}">{{ $corp->corp_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="office_id" class="block text-sm font-medium text-gray-600 mb-2">所属を選択してください</label>
                <select name="office_id" id="office_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition ease-in-out duration-300">
                    <option value="">所属</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="year" class="block text-sm font-medium text-gray-600 mb-2">年を選択してください</label>
                <select name="year" id="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition ease-in-out duration-300">
                    @php
                    $currentYear = date('Y');
                    $endYear = $currentYear + 5;
                @endphp
                @for ($i = $endYear; $i >= 2023; $i--)
                    <option value="{{ $i }}" @if ($selectedYear == $i) selected @endif>
                        {{ $i }} 年
                    </option>
                @endfor
                </select>
            </div>

            <div class="mb-6">
                <label for="month" class="block text-sm font-medium text-gray-600 mb-2">月を選択してください</label>
                <select name="month" id="month" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition ease-in-out duration-300">
                    @for ($i = 1; $i <= 12; $i++)
                            @php
                                // Convert month number to Japanese month name
                                $japaneseMonth = [
                                    1 => '1月',
                                    2 => '2月',
                                    3 => '3月',
                                    4 => '4月',
                                    5 => '5月',
                                    6 => '6月',
                                    7 => '7月',
                                    8 => '8月',
                                    9 => '9月',
                                    10 => '10月',
                                    11 => '11月',
                                    12 => '12月',
                                ];
                            @endphp
                            <option value="{{ $i }}" @if ($selectedMonth == $i + 1) selected @endif>
                                {{ $japaneseMonth[$i] }}</option>
                        @endfor
                </select>
            </div>

            <div class="text-center">
                <x-button purpose="search" type="submit" >
                    CSV出す
                </x-button>
            </div>
        </form>
    </div>
</div>


    <script>
        // Get the corporation and office dropdowns
        const corpSelect = document.getElementById('corps_id');
        const officeSelect = document.getElementById('office_id');

        // Get the offices data from the server
        const offices = @json($offices);

        // Function to populate the office dropdown based on the selected corporation
        function populateOfficeDropdown(corpId) {
            officeSelect.innerHTML = '<option value="">所属</option>';

            // Filter the offices based on the selected corporation ID
            const filteredOffices = offices.filter(office => office.corp_id == corpId);

            // Loop through the filtered offices and create options
            filteredOffices.forEach(office => {
                const option = document.createElement('option');
                option.value = office.id; // Use office.id as the value
                option.text = office.office_name; // Use office.office_name as the text
                officeSelect.add(option);
            });
        }

        // Add an event listener to the corporation dropdown
        corpSelect.addEventListener('change', () => {
            const selectedCorpId = corpSelect.value;
            populateOfficeDropdown(selectedCorpId);
        });

        // Populate the office dropdown when the page loads
        populateOfficeDropdown('{{ $selectedCorpId }}');
    </script>
@endsection
