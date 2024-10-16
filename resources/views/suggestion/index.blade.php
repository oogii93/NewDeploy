<x-app-layout>




<body class="bg-gray-100 pt-32">
    <canvas id="backgroundCanvas" class="fixed top-0 left-0 w-full h-full -z-10"></canvas>



    <div class="mt-4 py-4 relative z-1">



            <form action="" method="POST">
                @csrf
                <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h1 class="text-3xl font-bold text-center mb-6">投書</h1>



                    <div class="grid grid-cols-3 gap-4 mb-6  p-4 rounded border border-gray-300">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 border-gray-800">営業所</label>
                            @if(Auth::check())
                            @if(Auth::user()->office)
                                <input type="text" id="department" name="department" value="{{ Auth::user()->office->office_name }}"
                                class="w-full border border-gray-300" readonly>
                            @else
                                <p>User has no associated office</p>
                            @endif
                        @else
                            <p>User is not authenticated</p>
                        @endif

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">所属</label>
                            <input type="text" id="office" name="office"
                            value="{{ Auth::user()->division->name ?? ''}}"
                                class="w-full border border-gray-300" readonly>

                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">氏名</label>
                            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                            class="w-full border border-gray-300" readonly>
                        </div>
                    </div>


                    <div class="mb-4 flex space-x-4">
                        <div class="flex-1">
                            <label for="start_time" class="block text font-medium text-gray-700 mb-1">申請書日付</label>
                            <input type="date" id="request_date1" name="request_date1"
                            class="form-input  border border-gray-300">
                        </div>
                    </div>


                    <div class="mb-4 border border-gray-300">
                        <div class="flex">
                            <div class="w-1/4 border-r border-gray-300 p-2">
                                <label for="spouse_name_old" class="block text font-medium text-gray-700">式場住所</label>
                            </div>

                            <div class="w-3/4 flex flex-col">
                                <div class="flex">
                                    <div class="flex-1 p-2">
                                        <label for="furigana" class="block text font-medium text-gray-700 mb-1">フリガナ</label>
                                        <input type="text" id="place_address_furigana" name="place_address_furigana" class="form-input w-full">
                                    </div>

                                    <div class="flex-1 p-2">
                                        <label for="spouse_name" class="block text font-medium text-gray-700 mb-1">テ</label>
                                        <input type="text" id="place_address_name" name="place_address_name" class="form-input w-full">
                                    </div>
                                </div>

                                <div class="flex-grow"></div>

                                <div class="flex justify-end p-2">
                                    <div class="flex items-center">
                                        <label for="tel" class="text font-medium text-gray-700 mr-2">TEL:</label>
                                        <input type="text" id="place_phone" name="place_phone" class="form-input w-52">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">扶養義務 </label>
                        <div class="flex flex-col space-y-2">
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="support" value="1" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                    <span class="ml-2 text-sm text-gray-700">有り</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="support" value="0" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                    <span class="ml-2 text-sm text-gray-700">無し</span>
                                    <span class="px-8">※有りの場合:扶養家族変更届 (社内書式) を添付</span>
                                </label>
                            </div>


                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">結婚による氏名変更</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="name_change" value="1" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                <span class="ml-2 text-sm text-gray-700">有り</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="name_change" value="0" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                <span class="ml-2 text-sm text-gray-700">無し</span>
                                <span class="px-8">※有りの場合:氏名変更届 (社内書式) を添付</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">結婚による住所変更</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="address_change" value="1" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                <span class="ml-2 text-sm text-gray-700">有り</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="address_change" value="0" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                <span class="ml-2 text-sm text-gray-700">無し</span>
                                <span class="px-8">※有りの場合:住所変更届 (社内書式) を添付</span>
                            </label>
                        </div>

                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">緊急連絡先の変更</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="emergency_contact_change" value="1" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                <span class="ml-2 text-sm text-gray-700">有り</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="emergency_contact_change" value="0" class="form-radio h-4 w-4 text-green-300 focus:ring-green-300">
                                <span class="ml-2 text-sm text-gray-700">無し</span>
                                <span class="px-8">※有りの場合:緊急連絡先記入表 (社内書式) を添付 </span>

                            </label>
                        </div>
                    </div>





                    <div class="space-y-2">
                        <label for="boss_id" class="block text-sm font-medium text-gray-700">Select Boss</label>
                        <select name="boss_id" id="boss_id" class="block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                            <option value="">Select a boss</option>
                            {{-- @foreach($bosses as $boss)
                                <option value="{{ $boss->id }}">{{ $boss->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                    <div class="document-requirements mb-4 py-3">


                        <h3 class="main-title border-2 border-solid border-yellow-400 p-2">
                            高速料金、タクシー代、電車代は「旅費交通費伺書」を。
                            手土産代、取引先との食事、会食代等は「交際費・会議費伺書」を。
                        </h3>

                    </div>

                    <div class="px-2 py-2">
     <x-button purpose="search" type="submit">
            本社へ送信
     </x-button>
                    </div>





                </div>
            </div>




            </form>

    </div>




</body>
<script>
    const canvas = document.getElementById('backgroundCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];
    const particleCount = 100;
    const speedFactor = 0.5;

    function getRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r}, ${g}, ${b}, 0.5)`;
    }

    class Particle {
        constructor() {
            this.reset();
            this.color = getRandomColor();
        }
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 5 + 1;
            this.speedX = (Math.random() * 1 - 0.5) * speedFactor;
            this.speedY = (Math.random() * 1 - 0.5) * speedFactor;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;

            if (this.x < 0) this.x = canvas.width;
            if (this.x > canvas.width) this.x = 0;
            if (this.y < 0) this.y = canvas.height;
            if (this.y > canvas.height) this.y = 0;
        }
        draw() {
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function init() {
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }
        requestAnimationFrame(animate);
    }

    init();
    animate();

    window.addEventListener('resize', function() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        init();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');

        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.remove('translate-x-full');
        });
        closeMenu.addEventListener('click', function() {
            mobileMenu.classList.add('translate-x-full');
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0');
                    var yyyy = today.getFullYear();

                    today = yyyy + '-' + mm + '-' + dd;
                    document.getElementById('request_date1').value = today;
                });
</script>

</html>

</x-app-layout>
