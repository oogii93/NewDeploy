<div class="overflow-x-auto w-full">
    <div class="md:px-10 py-8 w-full">
        <div class="shadow overflow-hidden rounded border-b border-gray-200">

<table class="border-collapse border border-slate-400 min-w-full bg-white table-auto">
    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">申請ID</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">送信人</th>

            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">Application ID</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">日付け</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">状態</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">上司</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">動作</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">確認した人</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">確認した日付け</th>
        </tr>
    </thead>
    <tbody class="text-gray-700">
        @foreach ($applications as $application)
            <tr class="border-b border-gray-200 hover:bg-gray-200">
                <td class="border border-slate-300 px-4 py-2">{{ $application->id }}</td>

                <td class="border border-slate-300 px-4 py-2">{{ $application->user->name ?? 'N/A' }}</td>


                <td class="border border-slate-300 px-4 py-2 whitespace-nowrap hidden md:table-cell">{{ $application->applicationable_id }}</td>
                <td class="border border-slate-300 px-4 py-2 whitespace-nowrap hidden md:table-cell">{{ $application->created_at }}</td>

                <td class="border border-slate-300 px-4 py-2">
                    @if ($application->status == 'approved')
                        <div class="flex items-center">
                            <span>{{ $application->status }}</span>
                            <img src="{{ asset('images/approved.png') }}" alt="Approved" class="ml-2 w-10 h-10">
                        </div>
                    @elseif($application->status == 'denied')
                        <div class="flex items-center">
                            <span>{{ $application->status }}</span>
                            <img src="{{ asset('images/denied.png') }}" alt="Denied" class="ml-2 w-10 h-10">
                        </div>
                    @else
                        <span>{{ $application->status }}</span>
                    @endif
                </td>

                <td class="border border-slate-300 px-4 py-2">
                    {{ $application->boss ? $application->boss->name : 'No boss assigned' }}
                </td>




                <td class="border border-slate-300 px-4 py-2">
                    <a href="{{ route('applications.show', $application) }}"
                        class="text-blue-500 hover:underline">View</a>

                    <div class="px-2 py-2">
                        <input type="checkbox" id="checkbox_{{ $application->id }}" name="is_active" value="1"
                            {{ $application->is_checked ? 'checked disabled' : '' }}>

                        <button type="button" id="button_{{ $application->id }}"
                            class="bg-cyan-600  text-white font-bold py-2 px-4 rounded
               {{ $application->is_checked ? 'bg-gray-400 cursor-not-allowed' : '' }}"
                            onclick="checkApplication({{ $application->id }})"
                            {{ $application->is_checked ? 'disabled' : '' }}>
                            {{ $application->is_checked ? '確認済み' : '確認ボタン' }}
                        </button>
                </td>

                <td class="border border-slate-300 px-4 py-2">
                    <span id="checked_by_{{ $application->id }}">
                        {{ $application->checked_by ? \App\Models\User::find($application->checked_by)->name : 'N/A' }}
                    </span>
                </td>

                <td class="border border-slate-300 px-4 py-2 whitespace-nowrap hidden md:table-cell">
                    <span id="checked_date_{{ $application->id }}">
                        {{ $application->checked_at ? $application->checked_at->format('Y-m-d H:i') : 'N/A' }}
                    </span>
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
{{ $applications->links() }}
        </div>
        </div>
<script>
    function checkApplication(id) {
        const checkbox = document.getElementById(`checkbox_${id}`);
        const button = document.getElementById(`button_${id}`);
        const isChecked = checkbox.checked;

        if (!isChecked) {
            alert('Please check the checkbox before confirming.');
            return;
        }

        axios.post(`/applications/${id}/check`, {
                is_checked: isChecked
            })
            .then(response => {
                if (response.data.success) {
                    document.getElementById(`checked_by_${id}`).textContent = response.data.checked_by;
                    document.getElementById(`checked_date_${id}`).textContent = response.data.checked_at;

                    // Disable the button and change its appearance
                    button.disabled = true;
                    button.classList.remove('bg-green-500', 'hover:bg-green-700');
                    button.classList.add('bg-gray-400', 'cursor-not-allowed');
                    button.textContent = '確認済み';

                    // Disable the checkbox
                    checkbox.disabled = true;
                }
            })
            .catch(error => console.error(error));
    }
</script>
