<x-app-layout>
    <div class="py-10 bg-gray-100 shadow-sm min-h-screen">
        <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-sm mx-auto">
            <h2 class="text-xl font-semibold mb-4 text-center mt-2">社員フィルター</h2>


            <form action="{{ route('filter') }}" method="GET">
                @csrf
                <div>
                    <label for="corps_id" class="block mb-2 font px-2">会社を選択してください</label>
                    <select name="corps_id" id="corps_id" class="block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">会社</option>
                        @foreach($corps as $corp)
                            <option value="{{ $corp->id }}" @if($selectedCorpId == $corp->id) selected @endif>{{ $corp->corp_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <label for="office_id" class="block mb-2 px-2">所属を選択してください</label>
                    <select name="office_id" id="office_id" class="block w-full px-4 py-2 border border-gray-500  focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">所属</option>
                    </select>
                </div>
                <div class="mt-4">

                    <label for="user_id" class="block mb-2 px-2">ユーザーを選択してください</label>
                    <select name="user_id" id="user_id" class="block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">ユーザー</option>
                        <option value="all">全員</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="year" class="block mb-2 px-2">年を選択してください</label>
                    <select name="year" id="year" class="block w-full px-4 py-2 border border-gray-500 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @for ($i = date('Y') - 1; $i <= date('Y') + 5; $i++)
                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mt-4">
                    <label for="month" class="block mb-2 px-2">月を選択してください</label>
                    <select name="month" id="month" class="block w-full px-4 py-2 border border-gray-500  focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
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
                            <option value="{{ $i }}" @if ($selectedMonth == $i) selected @endif>{{ $japaneseMonth[$i] }}</option>
                        @endfor
                    </select>

                </div>

<div class="py-2">

    <x-button purpose="search" type="submit">
        検索
    </x-button>

</div>

            </form>
        </div>
    </div>

    <script>
        // Get the corporation and office dropdowns
        const corpSelect = document.getElementById('corps_id');
        const officeSelect = document.getElementById('office_id');
        const userSelect = document.getElementById('user_id');

        // Get the offices data from the server
        const offices = @json($offices);
        const users = @json($users);
        console.log("Users:", users); // Output the value of users

        // Function to populate the office dropdown based on the selected corporation
        function populateOfficeDropdown(corpId) {
            officeSelect.innerHTML = '<option value="">所属</option>';

            // Filter the offices based on the selected corporation ID
            const filteredOffices = offices.filter(office => office.corp_id == corpId);

            // Loop through the filtered offices and create options
            filteredOffices.forEach(office => {
                const option = document.createElement('option');
                option.value = office.id;
                option.text = office.office_name;
                officeSelect.add(option);
            });

            // Populate the user dropdown based on the selected office
            populateUserDropdown();
        }

        function populateUserDropdown() {
    const selectedOfficeId = officeSelect.value;
    userSelect.innerHTML = '<option value="">ユーザー</option><option value="all">All</option>';

    // Filter users based on the selected office ID
    const filteredUsers = users.filter(user => user.office_id == selectedOfficeId);

    // Loop through the filtered users and append options to the user dropdown
    filteredUsers.forEach(user => {
        const option = document.createElement('option');
        option.value = user.id;
        option.text = user.name;
        userSelect.appendChild(option); // Append the option to the user dropdown
    });
}

        // Add event listeners to the corporation and office dropdowns
        corpSelect.addEventListener('change', () => {
            const selectedCorpId = corpSelect.value;
            populateOfficeDropdown(selectedCorpId);
        });

        officeSelect.addEventListener('change', populateUserDropdown);

        // Populate the office dropdown when the page loads
        populateOfficeDropdown('{{ $selectedCorpId }}');
    </script>

</x-app-layout>


