<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-sky-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-screen-sm shadow-xl rounded-lg p-4 sm:p-8 md:p-12">

        <div class="flex justify-center items-center h-24 mb-8">
            <div class="w-14">
                <img src="{{ asset('logo22.png') }}" alt="Logo" class="w-full h-auto">
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="w-full">
            @csrf
            <div class="relative flex items-center text-medium mb-8">
                <svg class="absolute ml-4" width="36" viewBox="0 0 24 24">
                    <path d="M20.822 18.096c-3.439-.794-6.64-1.49-5.09-4.418 4.72-8.912 1.251-13.678-3.732-13.678-5.082 0-8.464 4.949-3.732 13.678 1.597 2.945-1.725 3.641-5.09 4.418-3.073.71-3.188 2.236-3.178 4.904l.004 1h23.99l.004-.969c.012-2.688-.092-4.222-3.176-4.935z"/>
                </svg>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="bg-gray-200 rounded pl-16 py-5 text-medium focus:outline-none w-full" placeholder="メール入力" />
            </div>
            <div class="relative flex items-center text-medium mb-8">
                <svg class="absolute ml-4" viewBox="0 0 24 24" width="36">
                    <path d="m18.75 9h-.75v-3c0-3.309-2.691-6-6-6s-6 2.691-6 6v3h-.75c-1.24 0-2.25 1.009-2.25 2.25v10.5c0 1.241 1.01 2.25 2.25 2.25h13.5c1.24 0 2.25-1.009 2.25-2.25v-10.5c0-1.241-1.01-2.25-2.25-2.25zm-10.75-3c0-2.206 1.794-4 4-4s4 1.794 4 4v3h-8zm5 10.722v2.278c0 .552-.447 1-1 1s-1-.448-1-1v-2.278c-.595-.347-1-.985-1-1.722 0-1.103.897-2 2-2s2 .897 2 2c0 .737-.405 1.375-1 1.722z"/>
                </svg>
                <input type="password" name="password" required autocomplete="current-password" id="password" class="bg-gray-200 rounded pl-16 py-5 text-medium focus:outline-none w-full" placeholder="パスワード入力" />
            </div>

            <button class="bg-gradient-to-b from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-800 font-medium p-5 text-white uppercase w-full rounded text-medium">ログイン</button>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <div class="flex items-center justify-end mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-medium text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('パスワードを忘れましたか？') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
