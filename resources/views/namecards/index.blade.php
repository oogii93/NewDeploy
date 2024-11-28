<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Name Cards</h1>

        <a href="{{ route('namecards.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Add New Name Card
        </a>

        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Company</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($namecards as $namecard)
                <tr>
                    <td class="border p-2">{{ $namecard->name }}</td>
                    <td class="border p-2">{{ $namecard->company }}</td>
                    <td class="border p-2">{{ $namecard->email }}</td>
                    <td class="border p-2">
                        <a href="{{ route('namecards.show', $namecard) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded mr-2">show</a>
                        <form action="{{ route('namecards.destroy', $namecard) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-2 py-1 rounded"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
