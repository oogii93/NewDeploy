<div class="overflow-x-auto w-full">

    <div class="md:px-10 py-8 w-full">
        <div class="shadow overflow-hidden rounded border-b border-gray-200">
<table class="border-collapse border border-slate-400 min-w-full bg-white table-auto">

    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="border border-slate-300 text-left py-1 px-1 md:py-2 md:px-2 uppercase font-semibold text-xs md:text-sm whitespace-nowrap">申請ID</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">送信人</th>

            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">Application ID</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">日付け</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">状態</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm">actions</th>
            <th class="border border-slate-300 text-left py-2 px-2 md:py-3 md:px-4 uppercase font-semibold text-xs md:text-sm whitespace-nowrap hidden md:table-cell">comment</th>
        </tr>
    </thead>
    <tbody class="text-gray-700">
        @foreach ($applications as $application)
            <tr class="border-b border-gray-200 hover:bg-gray-200">
                <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">{{ $application->id }}</td>

                <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">{{ $application->user->name ?? 'N/A'}}</td>


                <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2 whitespace-nowrap hidden md:table-cell">{{ $application->applicationable_id }}</td>
                <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">{{ $application->created_at }}</td>

                <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">
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

                    @elseif($application->status == 'partially_approved')
                        <div class="flex items-center">
                            <span>{{ $application->status }}</span>
                            <img src="{{ asset('images/2.png') }}" alt="Denied" class="ml-2 w-10 h-10">
                        </div>
                    @else
                        <span>{{ $application->status }}</span>
                    @endif
                </td>




                <td class="border border-slate-300 px-2 py-1 md:px-4 md:py-2">
                    <a href="{{ route('applications.show', $application) }}"
                        class="text-blue-500 hover:underline">View</a>

                        <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <button type="submit" name="status" value="approved"
                                class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded {{ $application->status !== 'pending' && $application->status !== 'partially_approved' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $application->status !== 'pending' && $application->status !== 'partially_approved' ? 'disabled' : '' }}>
                                承認
                            </button>
                            <button type="submit" name="status" value="denied"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded {{ $application->status !== 'pending' && $application->status !== 'partially_approved' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $application->status !== 'pending' && $application->status !== 'partially_approved' ? 'disabled' : '' }}>
                                拒否
                            </button>
                            @if($application->status === 'partially_approved' || $application->status === 'pending')
                                <select name="division" id="division" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">

                                    <option value="1" {{ $application->division_name === '経理課' ? 'selected' : '' }}>経理課</option>
                                </select>
                            @endif
                        </form>

                </td>
                <td class="border border-slate-300 px-4 py-2 whitespace-nowrap hidden md:table-cell">
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
{{ $applications->links() }}
</div>
</div>
</div>

