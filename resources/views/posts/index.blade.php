<x-app-layout>
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/5 bg-gray-50 p-4 min-h-screen">
            <h2 class="text-lg font-bold mb-4 text-center">カテゴリー</h2>
            <ul class="space-y-2 text-l mb-2">
                @foreach($categories as $category)
                <li class="bg-sky-200 hover:bg-sky-300 rounded ">
                    <a href="{{ route('categories.posts', $category) }}" class="hover:underline hover:text-stone-800">{{ $category->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full md:w-3/4 p-4">
            <h1 class="text-2xl font-bold mb-4 mt-4 text-center">投稿</h1>
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                @role('admin')

                <x-button purpose="search" href="{{ route('posts.create') }}">
                    新規投稿
                </x-button>

                @endrole
                <form action="{{ route('posts.index') }}" method="GET" class="w-full md:w-auto">
                    <div class="flex">
                        <input type="text" name="search" value="{{ $searchQuery ?? '' }}" class="border border-gray-300 rounded-l px-3 py-2 h-10 w-full md:w-48" placeholder="検索">
                     <x-button purpose="submit" type="submit">
                        検索
                     </x-button>
                    </div>
                </form>
            </div>
            <div class="grid grid-cols-1 gap-4">
                @foreach ($posts as $post)




                <div class="bg-white shadow-md rounded-lg p-4">
                    <p class="text-sm text-gray-500">{{ $post->user->name }} <br> {{ $post->created_at->translatedFormat('Y年n月j日') }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-xl font-bold mb-2 hover:underline">{{ $post->title }}</a>
                    <div class="mt-2">
                        @foreach($post->tags as $tag)
                        <a href="{{ route('posts.tag', $tag->id) }}" class="inline-block bg-gray-200 hover:bg-gray-300 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"> {{ $tag->name }} </a>
                        @endforeach
                    </div>
                    @auth
                    @if(Auth::user()->id === $post->user_id)
                    <div class="mt-4">
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-green-500 hover:text-green-700 mr-2">編集</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">消去</button>
                        </form>
                    </div>
                    @endif
                    @endauth
                    <div class="mt-4">

                        @if($post->corps->count() > 0)
                        <div class="corps-list">
                            <small class="text-blue-500 font-md">閲覧可能:
                                @foreach($post->corps as $corp)
                                    <span class="badge badge-info text-black">{{ $corp->corp_name }}</span>
                                @endforeach
                            </small>
                        </div>
                    @else
                        <div class="corps-list">
                            <small><span class="badge badge-secondary">Visible to all corps</span></small>
                        </div>
                    @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

</x-app-layout>
