<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .show {
            display: block;
        }

        .nav-menu {
            position: fixed;
            top: 0;
            right: 100%;
            width: 100%;
            height: 100%;
            z-index: 999;
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }

        .nav-menu.active {
            transform: translateX(0);
        }


        .hover-move {
            transition: transform 0.3s ease;
        }

        .flex:hover .hover-move {
            transform: translateY(-5px);
        }
    </style>


 <style>
        .bell-icon {
            display: inline-block;
            transition: transform 0.3s ease-in-out;
        }

        .bell-icon:hover {
            animation: ring 0.5s ease-in-out;
        }

        @keyframes ring {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-15deg);
            }

            75% {
                transform: rotate(15deg);
            }
        }
    </style>


</head>

<body>
    <div class="px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
        {{-- <div class="w-11">
            <img src="{{ asset('logo22.png') }}" alt="Logo">

        </div> --}}


        <div class="flex items-center mb-4 sm:mb-1">
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('logo22.png') }}" alt="Taisei Holdings Logo" class="h-14 w-auto sm:h-18 sm:w-auto mr-3 sm:mr-5">

            </a>
            <span class="text-lg sm:text-lg font-serif font-medium text-sky-600 px-2 ">Taisei Net
            </span>


        </div>


        <div class="flex justify-between ml-auto">


                <div>
                    <button id="menu-toggle" class="text-2xl focus:outline-none right-3 sticky text-black lg:hidden">☰</button>

                </div>

                <div class="lg:hidden md:hidden">
                    <a href="{{ route('notifications.index') }}" class="relative flex items-center">
                        <!-- Modified this line -->
                        <svg class="bell-icon w-10 h-10" height="200px" width="200px" version="1.1"
                        id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path style="fill:#FFAA00;"
                                d="M256,100.174c-27.619,0-50.087-22.468-50.087-50.087S228.381,0,256,0s50.087,22.468,50.087,50.087 S283.619,100.174,256,100.174z M256,33.391c-9.196,0-16.696,7.5-16.696,16.696s7.5,16.696,16.696,16.696 c9.196,0,16.696-7.5,16.696-16.696S265.196,33.391,256,33.391z">
                            </path>
                            <path style="fill:#F28D00;"
                                d="M256.006,0v33.394c9.194,0.003,16.69,7.5,16.69,16.693s-7.496,16.69-16.69,16.693v33.394 c27.618-0.004,50.081-22.469,50.081-50.087S283.624,0.004,256.006,0z">
                            </path>
                            <path style="fill:#FFAA00;"
                                d="M256,512c-46.043,0-83.478-37.435-83.478-83.478c0-9.228,7.467-16.696,16.696-16.696h133.565 c9.228,0,16.696,7.467,16.696,16.696C339.478,474.565,302.043,512,256,512z">
                            </path>
                            <path style="fill:#F28D00;"
                                d="M322.783,411.826h-66.777V512c46.042-0.004,83.473-37.437,83.473-83.478 C339.478,419.293,332.011,411.826,322.783,411.826z">
                            </path>
                            <path style="fill:#FFDA44;"
                                d="M439.652,348.113v-97.678C439.642,149,357.435,66.793,256,66.783 C154.565,66.793,72.358,149,72.348,250.435v97.678c-19.41,6.901-33.384,25.233-33.391,47.017 c0.01,27.668,22.419,50.075,50.087,50.085h333.913c27.668-0.01,50.077-22.417,50.087-50.085 C473.036,373.346,459.063,355.014,439.652,348.113z">
                            </path>
                            <path style="fill:#FFAA00;"
                                d="M439.652,348.113v-97.678C439.642,149,357.435,66.793,256,66.783v378.432h166.957 c27.668-0.01,50.077-22.417,50.087-50.085C473.036,373.346,459.063,355.014,439.652,348.113z">
                            </path>
                            <path style="fill:#FFF3DB;"
                                d="M155.826,267.13c-9.228,0-16.696-7.467-16.696-16.696c0-47.022,28.011-89.283,71.381-107.641 c8.446-3.587,18.294,0.326,21.88,8.836c3.62,8.51-0.358,18.294-8.836,21.88c-31.012,13.142-51.033,43.337-51.033,76.925 C172.522,259.663,165.054,267.13,155.826,267.13z">
                            </path>
                        </g>
                    </svg>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </div>

        </div>




        <div class="hidden lg:flex w-full" id="navLinks">
            <ul class="flex flex-col lg:flex-row items-center w-full">


                <li class="relative group">
                    <a href=""
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                        height="30px" width="30px" version="1.1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 366.285 366.285" xml:space="preserve" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                        </g>
                        <g id="SVGRepo_iconCarrier">
                            <g id="XMLID_30_">
                                <g id="XMLID_31_">
                                    <path id="XMLID_71_" style="fill:#00969B;"
                                        d="M70.717,286.199l-31.01,31.01c-8.797,8.797-8.797,23.193,0,31.99l0,0 c8.797,8.797,23.193,8.797,31.99,0l33.232-33.232C92.038,307.853,80.499,297.794,70.717,286.199z">
                                    </path>
                                    <path id="XMLID_85_" style="fill:#1F2C47;"
                                        d="M55.702,365.797c-8.731,0-16.922-3.383-23.066-9.526 c-12.719-12.719-12.719-33.414,0-46.133l38.706-38.706l7.019,8.319c9.163,10.861,19.894,20.199,31.896,27.753l10.604,6.674 l-42.092,42.093C72.625,362.414,64.433,365.797,55.702,365.797z M70.356,300.703l-23.577,23.578 c-4.921,4.92-4.921,12.927,0,17.848c2.366,2.366,5.535,3.669,8.923,3.669s6.558-1.303,8.924-3.669l24.728-24.728 C82.585,312.355,76.237,306.775,70.356,300.703z">
                                    </path>
                                </g>
                                <g id="XMLID_88_">
                                    <path id="XMLID_89_" style="fill:#00969B;"
                                        d="M326.578,317.209l-31.01-31.01c-9.781,11.594-21.321,21.654-34.212,29.768 l33.232,33.232c8.797,8.797,23.193,8.797,31.99,0l0,0C335.375,340.402,335.375,326.006,326.578,317.209z">
                                    </path>
                                    <path id="XMLID_90_" style="fill:#1F2C47;"
                                        d="M310.583,365.797c-8.731,0-16.922-3.383-23.066-9.526l-42.092-42.092l10.604-6.674 c12.002-7.555,22.733-16.893,31.896-27.753l7.019-8.319l38.706,38.706c12.719,12.719,12.719,33.414,0,46.133 C327.505,362.414,319.314,365.797,310.583,365.797z M276.932,317.401l24.728,24.727c2.366,2.366,5.535,3.669,8.924,3.669 s6.558-1.303,8.923-3.669c4.921-4.92,4.921-12.927,0-17.848l-23.577-23.578C290.048,306.775,283.7,312.355,276.932,317.401z">
                                    </path>
                                </g>
                                <g id="XMLID_93_">
                                    <g id="XMLID_102_">
                                        <path id="XMLID_103_" style="fill:#00969B;"
                                            d="M133.143,52.971c-8.624-24.73-32.135-42.481-59.805-42.481 C38.357,10.49,10,38.847,10,73.827c0,25.882,15.532,48.123,37.776,57.95C61.985,93.703,93.703,64.165,133.143,52.971z">
                                        </path>
                                        <path id="XMLID_104_" style="fill:#1F2C47;"
                                            d="M53.437,145.208l-9.702-4.286C17.167,129.187,0,102.85,0,73.827 C0,33.389,32.899,0.49,73.337,0.49c31.159,0,58.988,19.767,69.248,49.188l3.493,10.017l-10.205,2.896 c-36.141,10.257-65.571,37.428-78.728,72.682L53.437,145.208z M73.337,20.49C43.927,20.49,20,44.417,20,73.827 c0,17.654,8.737,33.943,22.904,43.796c15.351-32.495,42.939-57.965,76.52-70.646C110,30.811,92.538,20.49,73.337,20.49z">
                                        </path>
                                    </g>
                                    <g id="XMLID_107_">
                                        <path id="XMLID_108_" style="fill:#00969B;"
                                            d="M292.948,10.49c-27.671,0-51.182,17.751-59.805,42.481 c39.439,11.194,71.158,40.732,85.366,78.805c22.244-9.827,37.776-32.068,37.776-57.95 C356.285,38.847,327.928,10.49,292.948,10.49z">
                                        </path>
                                        <path id="XMLID_109_" style="fill:#1F2C47;"
                                            d="M312.848,145.208l-3.708-9.937c-13.157-35.253-42.587-62.424-78.728-72.682 l-10.205-2.896l3.493-10.017c10.26-29.421,38.089-49.188,69.248-49.188c40.438,0,73.337,32.899,73.337,73.337 c0,29.022-17.167,55.359-43.735,67.097L312.848,145.208z M246.861,46.978c33.581,12.68,61.169,38.15,76.52,70.646 c14.167-9.854,22.904-26.143,22.904-43.796c0-29.41-23.927-53.337-53.337-53.337C273.747,20.49,256.285,30.811,246.861,46.978z">
                                        </path>
                                    </g>
                                    <g id="XMLID_169_">
                                        <path id="XMLID_197_" style="fill:#1F2C47;"
                                            d="M183.143,348.485c-86.588,0-157.032-70.444-157.032-157.032 S96.555,34.42,183.143,34.42s157.032,70.444,157.032,157.032S269.73,348.485,183.143,348.485z M183.143,54.42 c-75.56,0-137.032,61.473-137.032,137.032s61.473,137.032,137.032,137.032s137.032-61.473,137.032-137.032 S258.702,54.42,183.143,54.42z">
                                        </path>
                                    </g>
                                    <g id="XMLID_223_">
                                        <path id="XMLID_224_" style="fill:#1F2C47;"
                                            d="M183.143,314.554c-67.878,0-123.102-55.223-123.102-123.102 S115.264,68.351,183.143,68.351v20c-56.851,0-103.102,46.251-103.102,103.102s46.251,103.102,103.102,103.102 s103.102-46.251,103.102-103.102h20C306.244,259.331,251.021,314.554,183.143,314.554z">
                                        </path>
                                    </g>
                                    <g id="XMLID_225_">
                                        <polygon id="XMLID_226_" style="fill:#1F2C47;"
                                            points="185.117,214.93 133.43,189.087 142.374,171.198 181.168,190.594 232.622,139.141 246.765,153.283 ">
                                        </polygon>
                                    </g>
                                </g>
                            </g>
                        </g>

                    </svg>

                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">勤怠入力</span>

                    </a>


                    <div
                        class="absolute z-10 hidden bg-white divide-y divide-gray-100 shadow-lg group-hover:block top-full left-0">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">勤怠入力</a>
                        <a href="{{ route('other') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">全員勤怠一覧</a>


                    </div>

                </li>

                <li class="relative group">
                    <a href=""
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                        height="30px" width="30px" viewBox="0 0 60 60" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                        </g>
                        <g id="SVGRepo_iconCarrier">
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <title>Paperdesk</title>
                            <desc>Created with Sketch.</desc>
                            <defs> </defs>
                            <g id="colored" stroke="none" stroke-width="1" fill="none"
                                fill-rule="evenodd" sketch:type="MSPage">
                                <g id="Marketing_sliced" sketch:type="MSLayerGroup"
                                    transform="translate(-480.000000, 0.000000)"> </g>
                                <g id="Marketing" sketch:type="MSLayerGroup"
                                    transform="translate(-472.000000, 0.000000)" stroke="#314E55"
                                    stroke-width="2" stroke-linejoin="round">
                                    <g id="Papersdesk" transform="translate(475.000000, 6.000000)"
                                        sketch:type="MSShapeGroup">
                                        <rect id="Rectangle-1493" stroke-linecap="round" fill="#e6da8e" x="0"
                                            y="29" width="55" height="20"> </rect>
                                        <path d="M20,34 L35,34" id="Line" stroke-linecap="square"> </path>
                                        <rect id="Rectangle-1494" stroke-linecap="round" fill="#f8f7f7" x="10"
                                            y="9" width="24" height="20"> </rect>
                                        <path d="M37,6 L37,28.8266802 L13,28.8266802" id="Rectangle-1494"
                                            stroke-linecap="round"
                                            transform="translate(25.000000, 17.413340) scale(1, -1) translate(-25.000000, -17.413340) ">
                                        </path>
                                        <path d="M40,3 L40,28.9098058 L16,28.9098058" id="Rectangle-1494"
                                            stroke-linecap="round"
                                            transform="translate(28.000000, 15.954903) scale(1, -1) translate(-28.000000, -15.954903) ">
                                        </path>
                                        <path d="M43,0 L43,28.8638468 L19,28.8638468" id="Rectangle-1494"
                                            stroke-linecap="round"
                                            transform="translate(31.000000, 14.431923) scale(1, -1) translate(-31.000000, -14.431923) ">
                                        </path>
                                        <path d="M54.9083136,28.8929167 L50.2690171,19.7056894" id="Path-3383"
                                            stroke-linecap="round"> </path>
                                        <path d="M4.63929653,28.8929167 L0,19.7056894" id="Path-3383"
                                            stroke-linecap="round"
                                            transform="translate(2.319648, 24.299303) scale(-1, 1) translate(-2.319648, -24.299303) ">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>

                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">各種申請</span>

                    </a>


                    <div
                        class="absolute z-10 hidden bg-white divide-y divide-gray-100 shadow-lg group-hover:block top-full left-0">
                        <a href="{{ route('forms.index') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">各種申請</a>
                        <a href="{{ route('applications.index') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">申請履歴</a>


                    </div>

                </li>


                @auth


                @if (auth()->user()->is_boss)
                    <div
                        class="flex flex-col items-center justify-center w-24 h-16  bg-white border border-gray-200 hover:bg-gray-100">
                        <li class="relative group">
                            <a href=""
                                class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">
                                <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                                    height="30px" width="30px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 440.928 440.928" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g id="XMLID_28_">
                                                <g>
                                                    <path style="fill:#E2B369;"
                                                        d="M398.104,282.228l-0.01,109.36c-8.81-2.04-15.4-9.94-15.4-19.37v-97.61 C386.844,278.558,392.174,281.298,398.104,282.228z">
                                                    </path>
                                                    <rect x="42.824" y="401.118" style="fill:#E2B369;" width="355.27"
                                                        height="30.81"></rect>
                                                    <path
                                                        d="M58.224,372.218h0.01v-97.61c-4.16,3.95-9.49,6.69-15.41,7.62v109.36C51.634,389.548,58.224,381.648,58.224,372.218z M187.444,281.518c0,18.2,14.81,33.02,33.02,33.02c18.2,0,33.01-14.82,33.01-33.02v-29.26c0-58.81,8.13-114.44,24.16-165.34 c1.82-5.8,2.75-11.85,2.75-18c0-16.53-6.59-31.93-18.56-43.35c-11.25-10.74-25.84-16.57-41.34-16.57c-0.96,0-1.92,0.02-2.89,0.07 c-31.02,1.44-56.07,26.9-57.03,57.97c-0.2,6.59,0.66,13.1,2.56,19.33c16.14,53.05,24.32,105.46,24.32,155.77V281.518z M382.694,372.218c0,9.43,6.59,17.33,15.4,19.37l0.01-109.36c-5.93-0.93-11.26-3.67-15.41-7.62V372.218z M407.104,273.578 l-0.01,123.05v44.3H33.824v-39.81v-127.54h4.5c10.97,0,19.9-8.93,19.9-19.91h0.01v-4.16h120.21v-7.37 c0-49.42-8.05-100.95-23.93-153.15c-2.19-7.17-3.17-14.65-2.94-22.23c1.1-35.73,29.91-65.02,65.6-66.68 c19.05-0.89,37.11,5.85,50.87,18.98c13.76,13.14,21.34,30.85,21.34,49.86c0,7.07-1.07,14.03-3.17,20.71 c-15.5,49.22-23.46,103.01-23.71,159.88h120.19v4.16c0,10.98,8.93,19.91,19.91,19.91H407.104z M398.094,431.928v-30.81H42.824 v30.81H398.094z M59.254,392.118h322.41c-3.95-4.16-6.69-9.48-7.62-15.4H66.874C65.944,382.638,63.214,387.958,59.254,392.118z M373.694,367.718v-109.21h-111.22v23.01c0,23.17-18.84,42.02-42.01,42.02s-42.02-18.85-42.02-42.02v-23.01H67.234v109.21 H373.694z">
                                                    </path>
                                                    <path style="fill:#E2B369;"
                                                        d="M374.044,376.718c0.93,5.92,3.67,11.24,7.62,15.4H59.254c3.96-4.16,6.69-9.48,7.62-15.4H374.044z">
                                                    </path>
                                                    <path style="fill:#FFCC73;"
                                                        d="M253.474,281.518c0,18.2-14.81,33.02-33.01,33.02c-18.21,0-33.02-14.82-33.02-33.02v-39.38 c0-50.31-8.18-102.72-24.32-155.77c-1.9-6.23-2.76-12.74-2.56-19.33c0.96-31.07,26.01-56.53,57.03-57.97 c0.97-0.05,1.93-0.07,2.89-0.07c15.5,0,30.09,5.83,41.34,16.57c11.97,11.42,18.56,26.82,18.56,43.35c0,6.15-0.93,12.2-2.75,18 c-16.03,50.9-24.16,106.53-24.16,165.34V281.518z">
                                                    </path>
                                                    <path style="fill:#FFCC73;"
                                                        d="M178.444,281.518c0,23.17,18.85,42.02,42.02,42.02s42.01-18.85,42.01-42.02v-23.01h111.22v109.21 H67.234v-109.21h111.21V281.518z">
                                                    </path>
                                                    <path style="fill:#E2B369;"
                                                        d="M58.234,274.608v97.61h-0.01c0,9.43-6.59,17.33-15.4,19.37v-109.36 C48.744,281.298,54.074,278.558,58.234,274.608z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">承認</span>
                            </a>


                            <div
                                class="absolute z-10 hidden bg-white divide-y divide-gray-100 shadow-lg group-hover:block top-full left-0">
                                <a href="{{ route('applications.boss_index') }}"
                                    class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">申請書(上司)</a>
                                <a href="{{ route('time_off_boss.index') }}"
                                    class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">勤怠届(上司)</a>
                            </div>
                    </div>
                    </li>
                @endif
            @endauth


            <li class="relative group">
                <a href="{{ route('forms2.index') }}"
                    class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">


                    <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                    height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFDC64;" d="M358.614,102.079H50.772c-4.722,0-8.551,3.829-8.551,8.551v179.574h25.653 c9.445,0,17.102,7.656,17.102,17.102c0,9.445-7.658,17.102-17.102,17.102H42.221v25.653c0,4.722,3.829,8.551,8.551,8.551h316.393 V110.63C367.165,105.908,363.336,102.079,358.614,102.079z"></path> <path style="fill:#C7CFE2;" d="M469.779,238.898H367.165v119.716h136.818v-85.512C503.983,254.212,488.669,238.898,469.779,238.898z "></path> <path style="fill:#AFB9D2;" d="M367.165,264.551h92.638c9.446,0,17.102,7.656,17.102,17.102v76.96h-109.74V264.551z"></path> <path style="fill:#C7CFE2;" d="M435.574,136.284h-68.409v34.205h94.063v-8.551C461.228,147.769,449.742,136.284,435.574,136.284z"></path> <polygon style="fill:#B4E6FF;" points="469.779,238.898 452.676,170.489 367.165,170.489 367.165,238.898 "></polygon> <circle style="fill:#FFFFFF;" cx="204.693" cy="213.244" r="68.409"></circle> <path style="fill:#F1F4FB;" d="M469.779,273.102h34.205v34.205h-17.102c-9.446,0-17.102-7.656-17.102-17.102V273.102z"></path> <path style="fill:#959CB5;" d="M427.023,298.756c-25.772,0-48.194,14.265-59.858,35.317v24.541h127.676 C490.624,324.877,461.902,298.756,427.023,298.756z"></path> <path style="fill:#AFB9D2;" d="M476.904,320.412v38.202h17.937C493.005,343.925,486.518,330.686,476.904,320.412z"></path> <circle style="fill:#5B5D6E;" cx="427.023" cy="367.165" r="42.756"></circle> <path style="fill:#9BD6FF;" d="M401.37,196.142h57.72l-6.413-25.653h-85.511v68.409h25.653v-34.205 C392.818,199.971,396.647,196.142,401.37,196.142z"></path> <path style="fill:#FFC850;" d="M144.835,298.756c-21.593,0-40.819,10.028-53.355,25.653H67.875H42.221v25.653 c0,4.722,3.829,8.551,8.551,8.551h316.393v-34.205H198.19C185.654,308.784,166.428,298.756,144.835,298.756z"></path> <circle style="fill:#5B5D6E;" cx="144.835" cy="367.165" r="42.756"></circle> <path d="M476.158,231.363l-13.259-53.035c3.625-0.77,6.345-3.986,6.345-7.839v-8.551c0-18.566-15.105-33.67-33.67-33.67h-60.392 V110.63c0-9.136-7.432-16.568-16.568-16.568H50.772c-9.136,0-16.568,7.432-16.568,16.568V256c0,4.427,3.589,8.017,8.017,8.017 s8.017-3.589,8.017-8.017V110.63c0-0.294,0.239-0.534,0.534-0.534h307.841c0.295,0,0.534,0.24,0.534,0.534v145.372 c0,4.427,3.589,8.017,8.017,8.017c4.427,0,8.017-3.589,8.017-8.017v-9.088h94.569c0.007,0,0.014,0.002,0.021,0.002 c0.007,0,0.015-0.001,0.022-0.001c11.637,0.007,21.518,7.646,24.912,18.171h-24.928c-4.427,0-8.017,3.589-8.017,8.017v17.102 c0,13.851,11.268,25.119,25.119,25.119h9.086v35.273h-20.962c-6.886-19.884-25.787-34.205-47.982-34.205 s-41.097,14.321-47.982,34.205h-3.86v-60.392c0-4.427-3.589-8.017-8.017-8.017c-4.427,0-8.017,3.589-8.017,8.017v60.391H192.817 c-6.886-19.884-25.787-34.205-47.982-34.205s-41.097,14.321-47.982,34.205H50.772c-0.295,0-0.534-0.241-0.534-0.534v-17.637h34.739 c4.427,0,8.017-3.589,8.017-8.017c0-4.427-3.589-8.017-8.017-8.017h-42.75c-0.002,0-0.003,0-0.005,0s-0.003,0-0.005,0H8.017 c-4.427,0-8.017,3.589-8.017,8.017c0,4.427,3.589,8.017,8.017,8.017h26.188v17.637c0,9.136,7.432,16.568,16.568,16.568h43.304 c-0.002,0.178-0.014,0.356-0.014,0.534c0,27.995,22.777,50.772,50.772,50.772s50.772-22.777,50.772-50.772 c0-0.178-0.012-0.356-0.014-0.534h180.67c-0.002,0.178-0.014,0.356-0.014,0.534c0,27.995,22.777,50.772,50.772,50.772 c27.995,0,50.772-22.777,50.772-50.772c0-0.178-0.012-0.356-0.014-0.534h26.203c4.427,0,8.017-3.589,8.017-8.017v-85.512 C512,251.99,496.423,234.448,476.158,231.363z M375.182,178.505h71.235l13.094,52.376h-84.329V178.505z M435.574,144.301 c9.725,0,17.637,7.912,17.637,17.637v0.534h-78.029v-18.171H435.574z M144.835,401.904c-19.155,0-34.739-15.583-34.739-34.739 c0-19.156,15.584-34.739,34.739-34.739c19.155,0,34.739,15.583,34.739,34.739C179.574,386.321,163.99,401.904,144.835,401.904z M427.023,401.904c-19.155,0-34.739-15.583-34.739-34.739c0-19.156,15.584-34.739,34.739-34.739 c19.155,0,34.739,15.583,34.739,34.739C461.762,386.321,446.178,401.904,427.023,401.904z M486.881,299.29 c-5.01,0-9.086-4.076-9.086-9.086v-9.086h18.171v18.171H486.881z"></path> <path d="M144.835,350.597c-9.136,0-16.568,7.432-16.568,16.568c0,9.136,7.432,16.568,16.568,16.568 c9.136,0,16.568-7.432,16.568-16.568C161.403,358.029,153.971,350.597,144.835,350.597z"></path> <path d="M427.023,350.597c-9.136,0-16.568,7.432-16.568,16.568c0,9.136,7.432,16.568,16.568,16.568s16.568-7.432,16.568-16.568 C443.591,358.029,436.159,350.597,427.023,350.597z"></path> <path d="M205.228,324.409c0,4.427,3.589,8.017,8.017,8.017H332.96c4.427,0,8.017-3.589,8.017-8.017c0-4.427-3.589-8.017-8.017-8.017 H213.244C208.817,316.392,205.228,319.982,205.228,324.409z"></path> <path d="M25.119,298.221h102.614c4.427,0,8.017-3.589,8.017-8.017c0-4.427-3.589-8.017-8.017-8.017H25.119 c-4.427,0-8.017,3.589-8.017,8.017C17.102,294.632,20.692,298.221,25.119,298.221z"></path> <path d="M204.693,136.818c-42.141,0-76.426,34.285-76.426,76.426s34.285,76.426,76.426,76.426s76.426-34.285,76.426-76.426 S246.834,136.818,204.693,136.818z M204.693,273.637c-33.3,0-60.392-27.092-60.392-60.392s27.092-60.392,60.392-60.392 s60.392,27.092,60.392,60.392S237.993,273.637,204.693,273.637z"></path> <path d="M212.71,209.924V179.04c0-4.427-3.589-8.017-8.017-8.017s-8.017,3.589-8.017,8.017v34.205c0,2.126,0.844,4.164,2.348,5.668 l25.653,25.653c1.565,1.565,3.617,2.348,5.668,2.348s4.103-0.782,5.668-2.348c3.131-3.131,3.131-8.206,0-11.337L212.71,209.924z"></path> </g></svg>

                    <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">社内注文</span>
                </a>
            </li>




            <li class="relative group">
                <div
                    class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">
                    <svg class="transition-transform duration-300 hover:scale-105" height="30px" width="30px"
                        version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64"
                        enable-background="new 0 0 64 64" xml:space="preserve" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <g>
                                        <path fill="#506C7F"
                                            d="M50,2c-0.553,0-1,0.447-1,1v1v2v4c0,0.553,0.447,1,1,1s1-0.447,1-1V6V4V3C51,2.447,50.553,2,50,2z">
                                        </path>
                                        <path fill="#506C7F"
                                            d="M14,2c-0.553,0-1,0.447-1,1v1v2v4c0,0.553,0.447,1,1,1s1-0.447,1-1V6V4V3C15,2.447,14.553,2,14,2z">
                                        </path>
                                    </g>
                                    <path fill="#f5f5f4"
                                        d="M62,60c0,1.104-0.896,2-2,2H4c-1.104,0-2-0.896-2-2V17h60V60z"></path>
                                    <path fill="#f3dd8c"
                                        d="M62,15H2V8c0-1.104,0.896-2,2-2h7v4c0,1.657,1.343,3,3,3s3-1.343,3-3V6h30v4c0,1.657,1.343,3,3,3 s3-1.343,3-3V6h7c1.104,0,2,0.896,2,2V15z">
                                    </path>
                                    <g>
                                        <path fill="#394240"
                                            d="M11,54h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C10,53.553,10.447,54,11,54z M12,49h4v3h-4V49z">
                                        </path>
                                        <path fill="#394240"
                                            d="M23,54h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C22,53.553,22.447,54,23,54z M24,49h4v3h-4V49z">
                                        </path>
                                        <path fill="#394240"
                                            d="M35,54h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C34,53.553,34.447,54,35,54z M36,49h4v3h-4V49z">
                                        </path>
                                        <path fill="#394240"
                                            d="M11,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C10,42.553,10.447,43,11,43z M12,38h4v3h-4V38z">
                                        </path>
                                        <path fill="#394240"
                                            d="M23,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C22,42.553,22.447,43,23,43z M24,38h4v3h-4V38z">
                                        </path>
                                        <path fill="#394240"
                                            d="M35,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C34,42.553,34.447,43,35,43z M36,38h4v3h-4V38z">
                                        </path>
                                        <path fill="#394240"
                                            d="M47,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C46,42.553,46.447,43,47,43z M48,38h4v3h-4V38z">
                                        </path>
                                        <path fill="#394240"
                                            d="M11,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C10,31.553,10.447,32,11,32z M12,27h4v3h-4V27z">
                                        </path>
                                        <path fill="#394240"
                                            d="M23,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C22,31.553,22.447,32,23,32z M24,27h4v3h-4V27z">
                                        </path>
                                        <path fill="#394240"
                                            d="M35,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C34,31.553,34.447,32,35,32z M36,27h4v3h-4V27z">
                                        </path>
                                        <path fill="#394240"
                                            d="M47,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C46,31.553,46.447,32,47,32z M48,27h4v3h-4V27z">
                                        </path>
                                        <path fill="#394240"
                                            d="M60,4h-7V3c0-1.657-1.343-3-3-3s-3,1.343-3,3v1H17V3c0-1.657-1.343-3-3-3s-3,1.343-3,3v1H4 C1.789,4,0,5.789,0,8v52c0,2.211,1.789,4,4,4h56c2.211,0,4-1.789,4-4V8C64,5.789,62.211,4,60,4z M49,3c0-0.553,0.447-1,1-1 s1,0.447,1,1v7c0,0.553-0.447,1-1,1s-1-0.447-1-1V3z M13,3c0-0.553,0.447-1,1-1s1,0.447,1,1v7c0,0.553-0.447,1-1,1s-1-0.447-1-1 V3z M62,60c0,1.104-0.896,2-2,2H4c-1.104,0-2-0.896-2-2V17h60V60z M62,15H2V8c0-1.104,0.896-2,2-2h7v4c0,1.657,1.343,3,3,3 s3-1.343,3-3V6h30v4c0,1.657,1.343,3,3,3s3-1.343,3-3V6h7c1.104,0,2,0.896,2,2V15z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <rect x="12" y="27" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="24" y="27" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="36" y="27" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="48" y="27" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="12" y="38" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="24" y="38" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="36" y="38" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="48" y="38" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="12" y="49" fill="#00969B" width="4" height="3"></rect>
                                    <rect x="24" y="49" fill="#00969B" width="4" height="3">
                                    </rect>
                                    <rect x="36" y="49" fill="#00969B" width="4" height="3"></rect>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <a href="" class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">スケジュール</a>
                </div>

                <div
                    class="absolute z-10 hidden bg-white divide-y divide-gray-100 shadow-lg group-hover:block top-full left-0">
                    <a href="{{ route('room.index') }}"
                        class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">会議室</a>
                    <a href="{{ route('actionSchedule.index') }}"
                        class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">行動予定表</a>
                    <a href="{{ route('companySchedule.index') }}"
                        class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">会社予定表</a>
                </div>
            </li>





                {{-- <li class="relative group">
                    <a href="{{ route('forms.index') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">
                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" viewBox="0 0 60 60" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                            </g>
                            <g id="SVGRepo_iconCarrier">
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <title>Paperdesk</title>
                                <desc>Created with Sketch.</desc>
                                <defs> </defs>
                                <g id="colored" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Marketing_sliced" sketch:type="MSLayerGroup"
                                        transform="translate(-480.000000, 0.000000)"> </g>
                                    <g id="Marketing" sketch:type="MSLayerGroup"
                                        transform="translate(-472.000000, 0.000000)" stroke="#314E55"
                                        stroke-width="2" stroke-linejoin="round">
                                        <g id="Papersdesk" transform="translate(475.000000, 6.000000)"
                                            sketch:type="MSShapeGroup">
                                            <rect id="Rectangle-1493" stroke-linecap="round" fill="#e6da8e" x="0"
                                                y="29" width="55" height="20"> </rect>
                                            <path d="M20,34 L35,34" id="Line" stroke-linecap="square"> </path>
                                            <rect id="Rectangle-1494" stroke-linecap="round" fill="#f8f7f7" x="10"
                                                y="9" width="24" height="20"> </rect>
                                            <path d="M37,6 L37,28.8266802 L13,28.8266802" id="Rectangle-1494"
                                                stroke-linecap="round"
                                                transform="translate(25.000000, 17.413340) scale(1, -1) translate(-25.000000, -17.413340) ">
                                            </path>
                                            <path d="M40,3 L40,28.9098058 L16,28.9098058" id="Rectangle-1494"
                                                stroke-linecap="round"
                                                transform="translate(28.000000, 15.954903) scale(1, -1) translate(-28.000000, -15.954903) ">
                                            </path>
                                            <path d="M43,0 L43,28.8638468 L19,28.8638468" id="Rectangle-1494"
                                                stroke-linecap="round"
                                                transform="translate(31.000000, 14.431923) scale(1, -1) translate(-31.000000, -14.431923) ">
                                            </path>
                                            <path d="M54.9083136,28.8929167 L50.2690171,19.7056894" id="Path-3383"
                                                stroke-linecap="round"> </path>
                                            <path d="M4.63929653,28.8929167 L0,19.7056894" id="Path-3383"
                                                stroke-linecap="round"
                                                transform="translate(2.319648, 24.299303) scale(-1, 1) translate(-2.319648, -24.299303) ">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>

                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">各種申請</span>
                    </a>
                </li> --}}














                {{-- <li class="relative group">
                    <a href="{{ route('other') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <circle style="fill:#00969B;" cx="351.019" cy="160.98" r="152.722"></circle>
                                <circle style="fill:#fcfcfc;" cx="351.019" cy="160.98" r="120.02"></circle>
                                <path style="fill:#1B4145;"
                                    d="M182.651,377.405L62.285,497.769c-12.535,12.535-26.135,4.615-39.402-8.652 C9.616,475.85,1.696,462.25,14.231,449.715l120.364-120.364l38.74,9.315L182.651,377.405z">
                                </path>
                                <path style="fill:#C2B8B9;"
                                    d="M194.008,366.598l-14.661,14.661l-48.055-48.055l14.661-14.661 c12.535-12.535,33.461-11.941,46.729,1.326C205.95,333.136,206.543,354.062,194.008,366.598z">
                                </path>
                                <path
                                    d="M351.021,0c-88.764,0-160.978,72.214-160.978,160.978s72.214,160.978,160.978,160.978S512,249.742,512,160.978 S439.785,0,351.021,0z M351.021,305.441c-79.657,0-144.462-64.805-144.462-144.462S271.366,16.516,351.021,16.516 s144.462,64.805,144.462,144.462S430.678,305.441,351.021,305.441z">
                                </path>
                                <path
                                    d="M283.908,93.866c-3.225,3.225-3.224,8.454,0,11.678c1.613,1.612,3.726,2.418,5.839,2.418s4.227-0.806,5.84-2.419 c14.806-14.806,34.493-22.961,55.435-22.961c20.941,0,40.627,8.154,55.434,22.961c3.224,3.226,8.453,3.225,11.678,0.001 c3.225-3.225,3.225-8.454,0-11.678c-17.925-17.928-41.759-27.8-67.112-27.8C325.669,66.066,301.834,75.939,283.908,93.866z">
                                </path>
                                <path
                                    d="M221.703,278.617l-31.759,31.759c-16.405-10.958-38.848-9.207-53.318,5.262L9.289,442.976 c-10.458,10.458-10.216,21.144-8.171,28.267c2.136,7.444,7.199,14.979,15.93,23.71c8.732,8.731,16.265,13.792,23.71,15.93 c2.264,0.651,4.887,1.118,7.75,1.118c6.142,0,13.383-2.155,20.517-9.289l111.81-111.81c0.003-0.003,0.007-0.007,0.011-0.01 c0.004-0.003,0.007-0.007,0.01-0.011l15.507-15.507c7.979-7.979,12.372-18.585,12.372-29.867c0-8.478-2.481-16.574-7.1-23.461 l31.749-31.749c3.225-3.226,3.225-8.454,0-11.679C230.157,275.394,224.928,275.394,221.703,278.617z M57.346,491.031 c-5.278,5.278-11.833,9.026-28.619-7.758c-16.784-16.783-13.036-23.34-7.758-28.617l105.979-105.981l36.377,36.377L57.346,491.031z M184.682,363.694l-9.678,9.678l-36.377-36.376l9.678-9.678c10.029-10.029,26.348-10.029,36.378,0 c4.858,4.858,7.534,11.317,7.534,18.188C192.216,352.377,189.541,358.836,184.682,363.694z">
                                </path>
                                <path
                                    d="M471.042,169.317c-4.519-0.622-8.685,2.536-9.308,7.055c-7.562,54.94-55.158,96.369-110.712,96.369 c-61.626,0-111.762-50.136-111.762-111.762S289.395,49.216,351.021,49.216c55.555,0,103.151,41.431,110.712,96.37 c0.622,4.519,4.792,7.683,9.308,7.055c4.519-0.621,7.677-4.789,7.056-9.306c-4.187-30.42-19.259-58.389-42.44-78.755 c-23.398-20.559-53.456-31.88-84.636-31.88c-70.733,0-128.279,57.546-128.279,128.279s57.546,128.279,128.279,128.279 c31.18,0,61.236-11.321,84.635-31.879c23.18-20.367,38.252-48.335,42.44-78.755C478.718,174.104,475.56,169.938,471.042,169.317z">
                                </path>
                            </g>
                        </svg>


                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">勤退情報確認</span>
                    </a>
                </li> --}}

                <li class="relative group">
                    <a href="{{ route('pdfCompany.index') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path style="fill:#00969B;"
                                    d="M468.426,79.546h-32.681l35.404,78.979h32.681V114.95C503.83,95.483,487.903,79.546,468.426,79.546z">
                                </path>
                                <path style="fill:#eeca90;"
                                    d="M471.149,114.95v43.574H234.213V79.546h201.532C455.222,79.546,471.149,95.483,471.149,114.95z">
                                </path>
                                <path style="fill:#FFBE35;"
                                    d="M468.426,123.12h-32.681l35.404,344.739h32.681V158.524 C503.83,139.058,487.892,123.12,468.426,123.12z">
                                </path>
                                <path style="fill:#FFCD60;"
                                    d="M435.745,123.12H256V79.546c0-19.467-15.937-35.404-35.404-35.404H76.253H43.574 c-19.478,0-35.404,15.937-35.404,35.404V467.86h462.979V158.524C471.149,139.058,455.212,123.12,435.745,123.12z">
                                </path>
                                <path style="fill:#00969B;"
                                    d="M426.627,372.307h-21.787l-38.204-59.272C399.372,313.035,426.627,339.572,426.627,372.307z">
                                </path>
                                <path style="fill:#eeca90;"
                                    d="M366.636,313.035c-32.735,0-60.002,26.537-60.002,59.272h98.206 C404.839,339.572,387.475,313.035,366.636,313.035z">
                                </path>
                                <g>
                                    <path style="fill:#00969B;"
                                        d="M365.907,214.96v65.394c18.062,0,32.703-14.641,32.703-32.692 C398.608,229.601,383.967,214.96,365.907,214.96z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M205.366,372.307h-21.787l-38.204-59.272C178.112,313.035,205.366,339.572,205.366,372.307z">
                                    </path>
                                </g>
                                <path style="fill:#eeca90;"
                                    d="M145.375,313.035c-32.735,0-60.002,26.537-60.002,59.272h98.206 C183.579,339.572,166.216,313.035,145.375,313.035z">
                                </path>
                                <path style="fill:#00969B;"
                                    d="M144.647,214.96v65.394c18.062,0,32.703-14.641,32.703-32.692 C177.349,229.601,162.708,214.96,144.647,214.96z">
                                </path>
                                <path style="fill:#5a817f;"
                                    d="M256.001,315.998l47.888,80.569h32.681C336.569,352.067,300.502,315.998,256.001,315.998z">
                                </path>
                                <path style="fill:#00969B;"
                                    d="M256.001,315.998c-44.503,0.002-80.569,36.07-80.569,80.569h128.457 C303.888,352.067,282.45,315.998,256.001,315.998z">
                                </path>
                                <path style="fill:#5a817f;"
                                    d="M256.588,194.415v88.892c24.282-0.305,43.869-20.088,43.869-44.446S280.871,194.72,256.588,194.415z">
                                </path>
                                <path style="fill:#00969B;"
                                    d="M256.588,194.415c-0.196-0.011-0.392-0.011-0.588-0.011c-0.196,0-0.392,0-0.588,0.011 c-24.282,0.305-43.869,20.088-43.869,44.446s19.587,44.141,43.869,44.446c0.196,0.011,0.392,0.011,0.588,0.011 c0.196,0,0.392,0,0.588-0.011c12.244-0.61,22.081-20.273,22.081-44.446S268.834,195.025,256.588,194.415z">
                                </path>
                                <g>
                                    <path style="fill:#eeca90;"
                                        d="M144.647,214.96c6.024,0,10.915,14.641,10.915,32.703c0,18.051-4.891,32.692-10.915,32.692 c-18.062,0-32.703-14.641-32.703-32.692C111.943,229.601,126.585,214.96,144.647,214.96z">
                                    </path>
                                    <path style="fill:#eeca90;"
                                        d="M365.907,214.96c6.024,0,10.915,14.641,10.915,32.703c0,18.051-4.891,32.692-10.915,32.692 c-18.062,0-32.703-14.641-32.703-32.692C333.204,229.601,347.844,214.96,365.907,214.96z">
                                    </path>
                                </g>
                                <path
                                    d="M468.426,71.38H288.681c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17h179.745 c15.017,0,27.234,12.217,27.234,27.234v9.595c-7.466-5.996-16.935-9.595-27.234-9.595H264.17V79.55 c0-24.027-19.548-43.574-43.574-43.574H43.574C19.548,35.976,0,55.523,0,79.55v388.304c0,4.513,3.657,8.17,8.17,8.17h495.66 c4.513,0,8.17-3.657,8.17-8.17V158.529v-43.574C512,90.928,492.452,71.38,468.426,71.38z M495.66,459.685H16.34V79.55 c0-15.017,12.217-27.234,27.234-27.234h177.021c15.017,0,27.234,12.217,27.234,27.234v43.574c0,4.513,3.657,8.17,8.17,8.17h212.426 c15.017,0,27.234,12.217,27.234,27.234V459.685z">
                                </path>
                                <path
                                    d="M367.352,288.533c22.537,0,40.871-18.335,40.871-40.872s-18.335-40.871-40.871-40.871s-40.871,18.334-40.871,40.871 S344.816,288.533,367.352,288.533z M367.352,223.132c13.527,0,24.53,11.005,24.53,24.53c0,13.527-11.005,24.531-24.53,24.531 s-24.53-11.005-24.53-24.531C342.822,234.137,353.827,223.132,367.352,223.132z">
                                </path>
                                <path
                                    d="M367.352,304.874c-11.091,0-22.089,2.754-31.807,7.966c-3.976,2.132-5.472,7.084-3.339,11.06 c2.132,3.975,7.082,5.475,11.06,3.339c7.352-3.941,15.681-6.025,24.086-6.025c25.396,0,46.524,18.624,50.448,42.928h-50.448 c-4.513,0-8.17,3.657-8.17,8.17c0,4.513,3.657,8.17,8.17,8.17h59.27c4.513,0,8.17-3.657,8.17-8.17 C434.793,335.127,404.539,304.874,367.352,304.874z">
                                </path>
                                <path
                                    d="M145.373,364.144H94.2c3.924-24.306,25.052-42.928,50.447-42.928c8.404,0,16.732,2.083,24.083,6.023 c3.977,2.136,8.931,0.638,11.06-3.339c2.133-3.976,0.637-8.928-3.339-11.06c-9.716-5.21-20.714-7.964-31.803-7.964 c-37.188,0-67.44,30.253-67.44,67.439c0,4.513,3.657,8.17,8.17,8.17h59.995c4.513,0,8.17-3.657,8.17-8.17 C153.543,367.801,149.886,364.144,145.373,364.144z">
                                </path>
                                <path
                                    d="M144.648,288.533c22.537,0,40.871-18.335,40.871-40.872s-18.334-40.871-40.871-40.871s-40.871,18.334-40.871,40.871 S122.112,288.533,144.648,288.533z M144.648,223.132c13.526,0,24.53,11.005,24.53,24.53c0,13.527-11.005,24.531-24.53,24.531 c-13.527,0-24.53-11.005-24.53-24.531C120.117,234.137,131.121,223.132,144.648,223.132z">
                                </path>
                                <path
                                    d="M256,291.487c29.016,0,52.623-23.606,52.623-52.623S285.016,186.241,256,186.241s-52.623,23.606-52.623,52.623 S226.984,291.487,256,291.487z M256,202.583c20.006,0,36.282,16.275,36.282,36.282c0,20.006-16.275,36.282-36.282,36.282 s-36.282-16.275-36.282-36.282S235.994,202.583,256,202.583z">
                                </path>
                                <path
                                    d="M256,307.827c-48.931,0-88.739,39.809-88.739,88.741c0,4.513,3.658,8.17,8.17,8.17H336.57c4.513,0,8.17-3.657,8.17-8.17 C344.74,347.635,304.932,307.827,256,307.827z M184.06,388.397c4.069-36.092,34.78-64.23,71.94-64.23s67.873,28.138,71.941,64.23 H184.06z">
                                </path>
                            </g>
                        </svg>
                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">共有ファイル</span>
                    </a>
                </li>

                <li class="relative group">
                    <a href="{{ route('warehouse.index') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <polygon style="fill:#f1d26c;"
                                    points="17.351,170.311 256.534,8.008 495.716,170.311 495.716,503.458 17.351,503.458 ">
                                </polygon>
                                <polygon style="fill:#00969B;"
                                    points="273.618,19.601 256.534,8.008 17.351,170.311 17.351,503.458 51.52,503.458 51.52,170.311 ">
                                </polygon>
                                <rect id="SVGCleanerId_0" x="102.774" y="213.022" style="fill:#74757B;"
                                    width="307.52" height="290.436"></rect>
                                <g>
                                    <rect id="SVGCleanerId_0_1_" x="102.774" y="213.022" style="fill:#74757B;"
                                        width="307.52" height="290.436"></rect>
                                </g>
                                <rect x="102.774" y="213.022" style="fill:#606268;" width="34.169" height="290.436">
                                </rect>
                                <rect x="85.689" y="178.853" style="fill:#D7D8D9;" width="341.689" height="34.169">
                                </rect>
                                <rect x="102.774" y="298.444" style="fill:#FDDD85;" width="102.507" height="102.507">
                                </rect>
                                <rect x="102.774" y="298.444" style="fill:#FDD042;" width="25.627" height="102.507">
                                </rect>
                                <rect x="136.943" y="298.444" style="fill:#E1A527;" width="34.169" height="51.253">
                                </rect>
                                <rect x="102.774" y="400.951" style="fill:#FDDD85;" width="102.507" height="102.507">
                                </rect>
                                <rect x="102.774" y="400.951" style="fill:#FDD042;" width="25.627" height="102.507">
                                </rect>
                                <rect x="136.943" y="400.951" style="fill:#E1A527;" width="34.169" height="51.253">
                                </rect>
                                <rect x="205.281" y="400.951" style="fill:#FDDD85;" width="102.507" height="102.507">
                                </rect>
                                <rect x="205.281" y="400.951" style="fill:#FDD042;" width="25.627" height="102.507">
                                </rect>
                                <rect x="239.449" y="400.951" style="fill:#E1A527;" width="34.169" height="51.253">
                                </rect>
                                <path
                                    d="M499.946,163.684L260.897,1.382c-2.713-1.843-6.211-1.842-8.927,0L12.554,163.684c-2.196,1.491-3.745,3.972-3.745,6.627 v333.147c0,4.423,4.119,8.542,8.542,8.542h478.365c4.424,0,7.474-4.119,7.474-8.542V170.311 C503.191,167.656,502.143,165.175,499.946,163.684z M93.164,205.548v-18.152h325.673v18.152H93.164z M144.417,306.987h18.152v35.237 h-18.152V306.987z M136.943,358.24h34.169c4.423,0,7.474-4.119,7.474-8.542v-42.711h18.152v86.49h-25.627h-34.169h-26.694v-86.49 H128.4v42.711C128.4,354.12,132.52,358.24,136.943,358.24z M144.417,409.493h18.152v35.237h-18.152V409.493z M110.248,409.493H128.4 v42.711c0,4.423,4.119,8.542,8.542,8.542h34.169c4.423,0,7.474-4.119,7.474-8.542v-42.711h18.152v86.49h-86.49V409.493z M212.755,495.983v-86.49h18.152v42.711c0,4.423,4.119,8.542,8.542,8.542h34.169c4.424,0,7.474-4.119,7.474-8.542v-42.711h18.152 v86.49H212.755z M246.924,409.493h18.152v35.237h-18.152V409.493z M487.174,495.983h-69.406V324.071 c0-4.423-3.585-8.008-8.008-8.008c-4.424,0-8.008,3.586-8.008,8.008v171.912h-86.49v-95.032c0-4.423-3.051-7.474-7.474-7.474 h-95.032v-95.032c0-4.423-3.052-7.474-7.474-7.474h-95.032v-69.406h291.504v68.338c0,4.423,3.585,8.008,8.008,8.008 c4.424,0,8.008-3.586,8.008-8.008v-68.338h9.61c4.424,0,7.474-4.119,7.474-8.542v-34.169c0-4.423-3.051-7.474-7.474-7.474H85.689 c-4.423,0-8.542,3.052-8.542,7.474v34.169c0,4.423,4.119,8.542,8.542,8.542h8.542v274.419H24.826V174.555L256,17.687 l231.174,156.868V495.983z">
                                </path>
                                <path
                                    d="M214.357,76.88c0,4.423,3.586,8.008,8.008,8.008h68.338c4.424,0,8.008-3.586,8.008-8.008s-3.585-8.008-8.008-8.008h-68.338 C217.942,68.872,214.357,72.457,214.357,76.88z">
                                </path>
                                <path
                                    d="M290.703,103.041h-68.338c-4.423,0-8.008,3.586-8.008,8.008c0,4.423,3.586,8.008,8.008,8.008h68.338 c4.424,0,8.008-3.586,8.008-8.008C298.711,106.626,295.127,103.041,290.703,103.041z">
                                </path>
                                <path
                                    d="M290.703,137.21h-68.338c-4.423,0-8.008,3.586-8.008,8.008s3.586,8.008,8.008,8.008h68.338c4.424,0,8.008-3.586,8.008-8.008 S295.127,137.21,290.703,137.21z">
                                </path>
                                <path
                                    d="M136.943,383.867h34.169c4.423,0,8.008-3.586,8.008-8.008c0-4.423-3.586-8.008-8.008-8.008h-34.169 c-4.423,0-8.008,3.586-8.008,8.008C128.934,380.281,132.52,383.867,136.943,383.867z">
                                </path>
                                <path
                                    d="M171.112,470.357h-34.169c-4.423,0-8.008,3.586-8.008,8.008c0,4.423,3.586,8.008,8.008,8.008h34.169 c4.423,0,8.008-3.586,8.008-8.008C179.12,473.942,175.534,470.357,171.112,470.357z">
                                </path>
                                <path
                                    d="M273.618,470.357h-34.169c-4.423,0-8.008,3.586-8.008,8.008c0,4.423,3.586,8.008,8.008,8.008h34.169 c4.424,0,8.008-3.586,8.008-8.008C281.627,473.942,278.042,470.357,273.618,470.357z">
                                </path>
                            </g>
                        </svg>



                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">在庫状況</span>
                    </a>
                </li>












                <li class="relative group">
                    <a href="{{ route('posts.index') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">
                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="-39.26 -39.26 471.12 471.12" xml:space="preserve" fill="#050505"
                            stroke="#050505" stroke-width="0.003925980000000001">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path style="fill:#FFFFFF;"
                                    d="M340.364,83.749H41.891c-7.24,0-14.093-1.875-20.105-5.107v261.818 c0,16.743,13.576,30.384,30.384,30.384h288.259c16.743,0,30.384-13.576,30.384-30.384V114.133 C370.747,97.455,357.172,83.749,340.364,83.749z">
                                </path>
                                <path style="fill:#56ACE0;"
                                    d="M21.786,41.988c0,11.055,8.986,20.105,20.105,20.105h206.093v-40.21H41.891 C30.836,21.883,21.786,30.869,21.786,41.988z">
                                </path>
                                <path style="fill:#fcfcfc;"
                                    d="M348.962,340.461c0,4.719-3.879,8.598-8.598,8.598H52.17c-4.719,0-8.598-3.879-8.598-8.598V105.665 h296.792c4.719,0,8.598,3.879,8.598,8.598V340.461z">
                                </path>
                                <polygon style="fill:#56ACE0;"
                                    points="260.784,178.715 311.273,178.715 311.273,138.505 260.784,138.505 ">
                                </polygon>
                                <g>
                                    <path style="fill:#00969B;"
                                        d="M322.133,116.719h-72.21l0,0c-2.844,0-5.624,1.164-7.758,3.168 c-2.004,2.004-3.168,4.784-3.168,7.758v62.125c0,6.012,4.848,10.925,10.925,10.925h72.275c6.012,0,10.925-4.848,10.925-10.925 v-62.125C333.059,121.568,328.145,116.719,322.133,116.719z M311.273,178.715h-50.489v-40.339h50.489V178.715z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M322.133,245.883H69.366c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h252.768c6.012,0,10.925,4.848,10.925,10.925C333.059,241.034,328.145,245.883,322.133,245.883z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M195.814,200.566H69.366c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h126.319c6.012,0,10.925,4.848,10.925,10.925C206.61,195.653,201.762,200.566,195.814,200.566z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M322.133,291.265H69.366c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h252.768c6.012,0,10.925,4.849,10.925,10.925C333.059,286.416,328.145,291.265,322.133,291.265z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M322.133,336.582H69.366c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925 h252.768c6.012,0,10.925,4.848,10.925,10.925C333.059,331.733,328.145,336.582,322.133,336.582z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M87.467,121.309h8.339v37.236h-8.339l-17.778-23.337v23.337H61.35v-37.236h7.822l18.23,23.984 v-23.984H87.467z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M131.749,121.309v7.434h-18.554v7.628h16.679v7.111h-16.679v7.758h19.071v7.37h-27.41v-37.236 h26.893V121.309z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M151.402,142.836l6.594-21.398h8.663l6.594,21.398l7.434-21.398h9.051l-12.994,37.236h-6.206 l-8.21-25.988l-8.145,25.859h-6.206l-12.994-37.236h9.05L151.402,142.836z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M340.364,61.964H269.77V10.958c0-6.012-4.848-10.925-10.925-10.925H41.891 C18.812,0.032,0,18.78,0,41.923v298.473c0,28.768,23.402,52.17,52.17,52.17h288.259c28.768,0,52.17-23.402,52.17-52.17V114.133 C392.533,85.43,369.131,61.964,340.364,61.964z M41.891,21.883h206.093v40.081H41.891c-11.055,0-20.105-8.986-20.105-20.04 S30.836,21.883,41.891,21.883z M370.747,340.461c0,16.743-13.576,30.384-30.384,30.384H52.17 c-16.743,0-30.384-13.576-30.384-30.384V78.707c5.947,3.232,12.8,5.107,20.105,5.107h298.473c16.743,0,30.384,13.576,30.384,30.384 V340.461z">
                                    </path>
                                    <path style="fill:#00969B;"
                                        d="M207.257,151.693c-3.426,0-7.111-1.745-11.119-5.236l-4.913,6.012 c4.719,4.331,10.02,6.465,15.903,6.465c8.016,0,13.705-4.655,13.705-11.184c0.323-6.4-4.202-9.826-11.184-11.507 c-5.107-1.422-8.145-2.263-8.275-4.784c0.259-2.069,1.422-3.556,4.461-3.556c3.491,0,6.788,1.228,10.02,3.62l4.267-6.012 c-3.814-2.909-8.275-4.784-13.964-4.848c-8.275,0.453-13.123,3.879-13.382,10.99c0,6.723,4.008,9.826,12.541,11.766 c3.62,0.905,7.111,1.939,6.853,4.655C212.234,150.4,209.455,151.822,207.257,151.693z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">投稿</span>
                    </a>
                </li>












                <!--HR-->


                <!--KEIRI-->

                @auth
                    @if (auth()->user()->division && auth()->user()->division->name === '経理課')
                        <li class="relative group">
                            <a href="{{ route('ac.ac_dashboard') }}"
                                class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">
                                <!-- Your SVG icon here -->

                                <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                                    height="30px" width="30px" version="1.1" id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 491.52 491.52" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path style="fill:#64798A;"
                                            d="M399.128,0H92.391c-8.827,0-15.984,7.155-15.984,15.984v459.553c0,8.827,7.156,15.984,15.984,15.984 h306.737c8.828,0,15.984-7.156,15.984-15.984V15.984C415.112,7.155,407.956,0,399.128,0z">
                                        </path>
                                        <path style="fill:#D15241;"
                                            d="M221.828,185.954H119.992c-4.748,0-8.597,3.849-8.597,8.597v101.836c0,4.747,3.849,8.597,8.597,8.597 h101.836c4.748,0,8.596-3.85,8.596-8.597V194.551C230.424,189.803,226.575,185.954,221.828,185.954z">
                                        </path>
                                        <path style="fill:#31978C;"
                                            d="M371.528,185.954H269.692c-4.748,0-8.596,3.849-8.596,8.597v101.836c0,4.747,3.848,8.597,8.596,8.597 h101.836c4.748,0,8.597-3.85,8.597-8.597V194.551C380.125,189.803,376.276,185.954,371.528,185.954z">
                                        </path>
                                        <path style="fill:#D5D6DB;"
                                            d="M221.828,335.632H119.992c-4.748,0-8.597,3.848-8.597,8.596v101.836c0,4.748,3.849,8.597,8.597,8.597 h101.836c4.748,0,8.596-3.849,8.596-8.597V344.228C230.424,339.481,226.575,335.632,221.828,335.632z">
                                        </path>
                                        <path style="fill:#F6C358;"
                                            d="M371.528,335.632H269.692c-4.748,0-8.596,3.848-8.596,8.596v101.836c0,4.748,3.848,8.597,8.596,8.597 h101.836c4.748,0,8.597-3.849,8.597-8.597V344.228C380.125,339.481,376.276,335.632,371.528,335.632z">
                                        </path>
                                        <rect x="111.396" y="38.052" style="fill:#FFFFFF;" width="268.749"
                                            height="100.777"></rect>
                                        <rect x="111.396" y="125.916" style="fill:#EBF0F3;" width="268.749"
                                            height="12.913"></rect>
                                        <path style="fill:#E56353;"
                                            d="M221.828,176.385H119.992c-4.748,0-8.597,3.849-8.597,8.597v101.836c0,4.747,3.849,8.597,8.597,8.597 h101.836c4.748,0,8.596-3.85,8.596-8.597V184.982C230.424,180.234,226.575,176.385,221.828,176.385z">
                                        </path>
                                        <path style="fill:#44C4A1;"
                                            d="M371.528,176.385H269.692c-4.748,0-8.596,3.849-8.596,8.597v101.836c0,4.747,3.848,8.597,8.596,8.597 h101.836c4.748,0,8.597-3.85,8.597-8.597V184.982C380.125,180.234,376.276,176.385,371.528,176.385z">
                                        </path>
                                        <path style="fill:#EBF0F3;"
                                            d="M221.828,326.064H119.992c-4.748,0-8.597,3.848-8.597,8.596v101.836c0,4.748,3.849,8.597,8.597,8.597 h101.836c4.748,0,8.596-3.849,8.596-8.597V334.66C230.424,329.912,226.575,326.064,221.828,326.064z">
                                        </path>
                                        <path style="fill:#FCD462;"
                                            d="M371.528,326.064H269.692c-4.748,0-8.596,3.848-8.596,8.596v101.836c0,4.748,3.848,8.597,8.596,8.597 h101.836c4.748,0,8.597-3.849,8.597-8.597V334.66C380.125,329.912,376.276,326.064,371.528,326.064z">
                                        </path>
                                        <g>
                                            <polygon style="fill:#FFFFFF;"
                                                points="208.658,231.431 175.381,231.431 175.381,198.146 166.445,198.146 166.445,231.431 133.158,231.431 133.158,240.369 166.445,240.369 166.445,273.655 175.381,273.655 175.381,240.369 208.658,240.369 ">
                                            </polygon>
                                            <polygon style="fill:#FFFFFF;"
                                                points="344.141,206.051 320.61,229.581 297.074,206.044 290.755,212.364 314.291,235.9 290.755,259.437 297.074,265.756 320.61,242.22 344.147,265.756 350.466,259.437 326.929,235.9 350.46,212.37 ">
                                            </polygon>
                                        </g>
                                        <rect x="133.171" y="381.133" style="fill:#3A556A;" width="75.5"
                                            height="8.94"></rect>
                                        <g>
                                            <rect x="282.88" y="365.158" style="fill:#DC8744;" width="75.5"
                                                height="8.94"></rect>
                                            <rect x="282.88" y="397.056" style="fill:#DC8744;" width="75.5"
                                                height="8.94"></rect>
                                        </g>
                                    </g>
                                </svg>

                                <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">経理課</span></span>
                            </a>
                        </li>
                    @endif
                @endauth






                <li class="relative group">
                    <a href="https://app.metalife.co.jp/spaces"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100"
                        target="_blank" rel="noopener noreferrer">



                        <img src="{{ asset('meta.png') }}" alt="meta"
                            class="h-[30px] w-[30px] transition-transform duration-300 transform group-hover:-translate-y-1">

                        <span class="mt-1 text-gray-800 text-[11px] font-medium">MetaLife</span>
                    </a>


                </li>




                <li class="relative group">
                    <a href="{{ route('namecards.index') }}"
                    class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">



                                   <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px"
                    version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490.213 490.213" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#3CC676;" d="M464.535,150.565h-94.93c-3.891-38.906-37.35-70.03-77.812-70.03h-86.371 c-40.462,0-73.921,31.125-77.812,70.03H24.9c-14.006,0-24.9,10.115-24.9,24.122v274.675c0,14.006,10.116,28.012,24.9,28.012h440.413 c14.006,0,24.9-14.006,24.9-28.012V174.687C490.213,160.681,479.319,150.565,464.535,150.565z M311.246,172.353 c0,22.565-17.897,40.462-40.462,40.462H227.21c-22.565,0-40.462-17.897-40.462-40.462v-12.45c0-22.565,17.897-40.462,40.462-40.462 h43.574c22.565,0,40.462,17.897,40.462,40.462V172.353z"></path> <path style="fill:#24966A;" d="M464.535,166.128h-94.93c-3.891-38.906-37.35-70.03-77.812-70.03h-86.371 c-40.462,0-73.921,31.125-77.812,70.03H24.9c-14.006,0-24.9,14.006-24.9,28.012v255.222c0,14.006,10.116,28.012,24.9,28.012h440.413 c14.006,0,24.9-14.006,24.9-28.012V194.14C490.213,180.134,479.319,166.128,464.535,166.128z M311.246,172.353 c0,22.565-17.897,40.462-40.462,40.462H227.21c-22.565,0-40.462-17.897-40.462-40.462v-12.45c0-22.565,17.897-40.462,40.462-40.462 h43.574c22.565,0,40.462,17.897,40.462,40.462V172.353z"></path> <path style="fill:#D1E6ED;" d="M459.088,425.24c0,11.672-9.337,21.009-21.009,21.009H52.134c-11.672,0-21.009-9.337-21.009-21.009 V241.605c0-11.672,9.337-21.009,21.009-21.009h385.167c11.672,0,21.009,9.337,21.009,21.009V425.24H459.088z"></path> <path style="fill:#C61867;" d="M295.684,150.565V62.638c0-27.234-19.453-49.799-46.687-49.799S202.31,35.404,202.31,62.638v87.927 H295.684z"></path> <path style="fill:#9E085A;" d="M295.684,150.565V62.638c0-27.234-21.009-49.799-48.243-49.799S202.31,35.404,202.31,62.638"></path> <rect x="62.249" y="243.939" style="fill:#97B8BF;" width="178.967" height="171.185"></rect> <path style="fill:#00233F;" d="M186.748,284.401c0,16.34-13.228,29.568-29.568,29.568h-18.675c-16.34,0-27.234-15.562-27.234-31.903 l0,0c0-16.34,10.894-30.347,27.234-30.347h18.675c16.34,0,29.568,13.228,29.568,29.568V284.401z"></path> <rect x="124.498" y="329.532" style="fill:#F9BDA0;" width="46.687" height="38.906"></rect> <polygon style="fill:#E28F71;" points="171.185,368.438 149.398,368.438 124.498,329.532 171.185,329.532 "></polygon> <path style="fill:#FCCCB9;" d="M185.97,294.517c0,28.79-17.897,55.246-36.571,55.246c-18.675,0-36.571-26.456-36.571-55.246 c0-28.79,17.897-33.459,36.571-33.459S185.97,265.726,185.97,294.517z"></path> <path style="fill:#F9BDA0;" d="M149.398,261.058c18.675,0,36.571,4.669,36.571,33.459s-17.897,55.246-36.571,55.246"></path> <path style="fill:#00233F;" d="M160.292,259.501c0,3.891-3.112,7.781-7.003,7.781h-8.559c-3.891,0-7.003-3.891-7.003-7.781l0,0 c0-3.891,3.112-7.781,7.003-7.781h8.559C157.179,251.72,160.292,255.611,160.292,259.501L160.292,259.501z"></path> <polygon style="fill:#0C537A;" points="124.498,356.766 62.249,379.331 62.249,430.687 147.064,430.687 "></polygon> <polygon style="fill:#00233F;" points="122.942,356.766 70.809,387.112 62.249,430.687 147.064,430.687 "></polygon> <polygon style="fill:#D6D6D6;" points="123.72,352.097 108.936,358.322 119.052,386.334 147.842,429.131 147.842,368.438 "></polygon> <polygon style="fill:#FFFFFF;" points="123.72,352.097 148.62,368.438 119.052,385.556 "></polygon> <polygon style="fill:#0C537A;" points="175.854,356.766 241.216,379.331 241.216,430.687 151.733,430.687 "></polygon> <polygon style="fill:#00233F;" points="175.076,356.766 227.21,387.112 241.216,430.687 151.733,430.687 "></polygon> <polygon style="fill:#D6D6D6;" points="176.632,352.097 191.416,358.322 182.079,386.334 154.067,430.687 155.623,368.438 "></polygon> <polygon style="fill:#FFFFFF;" points="176.632,352.097 150.176,368.438 182.079,386.334 "></polygon> <polygon style="fill:#0C537A;" points="141.617,372.328 145.508,377.775 140.839,422.128 147.064,430.687 149.398,430.687 149.398,368.438 "></polygon> <polygon style="fill:#00233F;" points="157.179,372.328 154.067,377.775 159.514,422.128 153.289,430.687 149.398,430.687 149.398,368.438 "></polygon> <path style="fill:#FFC114;" d="M262.225,64.973c-4.669,7.781-14.784,10.116-22.565,4.669c-7.781-4.669-10.115-14.784-4.669-22.565 c4.669-7.781,14.784-10.115,22.565-4.669C265.337,47.076,267.672,57.191,262.225,64.973z"></path> <g> <path style="fill:#97B8BF;" d="M433.41,255.611c0,3.112-3.112,3.891-7.003,3.891H279.343c-3.891,0-7.003-0.778-7.003-3.891l0,0 c0-3.112,3.112-3.891,7.003-3.891h147.064C430.298,251.72,433.41,252.498,433.41,255.611L433.41,255.611z"></path> <path style="fill:#97B8BF;" d="M433.41,294.517c0,3.112-3.112,3.891-7.003,3.891H279.343c-3.891,0-7.003-0.778-7.003-3.891l0,0 c0-3.112,3.112-3.891,7.003-3.891h147.064C430.298,290.626,433.41,291.404,433.41,294.517L433.41,294.517z"></path> <path style="fill:#97B8BF;" d="M433.41,337.313c0,3.112-3.112,7.781-7.003,7.781H279.343c-3.891,0-7.003-4.669-7.003-7.781l0,0 c0-3.112,3.112-7.781,7.003-7.781h147.064C430.298,329.532,433.41,334.201,433.41,337.313L433.41,337.313z"></path> <path style="fill:#97B8BF;" d="M433.41,376.219c0,3.112-3.112,7.781-7.003,7.781H279.343c-3.891,0-7.003-4.669-7.003-7.781l0,0 c0-3.112,3.112-7.781,7.003-7.781h147.064C430.298,368.438,433.41,373.106,433.41,376.219L433.41,376.219z"></path> <path style="fill:#97B8BF;" d="M433.41,419.015c0,3.112-3.112,3.891-7.003,3.891H279.343c-3.891,0-7.003-0.778-7.003-3.891l0,0 c0-3.112,3.112-3.891,7.003-3.891h147.064C430.298,415.125,433.41,415.903,433.41,419.015L433.41,419.015z"></path> </g> </g>
                    </svg>

                        <span class="mt-1 text-gray-800 text-[11px] font-medium">名刺</span>
                    </a>


                </li>
                <li class="relative group">
                    <a href="{{ route('ComputerForm.index') }}"
                    class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">





                    <svg
                     height="30px" width="30px"
                    class="transition-transform duration-300 transform group-hover:-translate-y-1"
                    viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M403.2 803.2c-0.8 0-8.8 64-9.6 65.6-1.6 13.6-4 21.6-11.2 28-2.4 2.4-4.8 3.2-7.2 4.8-5.6 4-10.4 6.4-16.8 10.4-4.8 2.4-10.4 12-4.8 14.4h316.8c5.6-2.4 0-11.2-4.8-13.6-6.4-4-11.2-7.2-16.8-12-2.4-1.6-4.8-4-7.2-6.4-6.4-6.4-9.6-12-11.2-25.6 0-1.6-9.6-71.2-9.6-65.6" fill="#D2D5D6"></path><path d="M992 704.8V124c0-14.4-11.2-26.4-25.6-26.4H57.6c-14.4 0-25.6 12-25.6 26.4v581.6" fill="#938993"></path><path d="M84 149.6h856v503.2h-856z" fill="#E2D3E2"></path><path d="M376 137.6l576 528v-528z" fill="#FAFBFA"></path><path d="M32 704v72.8c0 14.4 11.2 26.4 25.6 26.4h908c14.4 0 25.6-12 25.6-26.4V704" fill="#D2D5D6"></path><path d="M511.2 754.4m-24 0a24 24 0 1 0 48 0 24 24 0 1 0-48 0Z" fill="#414343"></path><path d="M623.2 827.2c-0.8-24-1.6-24-1.6-24H404s-0.8 0-1.6 24h220.8z" fill="#0D1014"></path><path d="M449.6 568.8l-1.6 4z" fill="#99D9E6"></path><path d="M353.6 934.4c-0.8 0-2.4 0-3.2-0.8-4-1.6-7.2-5.6-7.2-10.4 0-8 6.4-16 11.2-18.4l3.2-1.6c4.8-2.4 8.8-4.8 12-8 1.6-0.8 2.4-1.6 4-2.4 0.8-0.8 1.6-0.8 2.4-1.6 4.8-4 6.4-10.4 8-22.4 8-67.2 8-67.2 16-67.2 4.8 0 8 3.2 8 8v2.4c-0.8 5.6-7.2 54.4-8 58.4-1.6 14.4-4.8 24.8-13.6 32.8-1.6 1.6-4 3.2-5.6 4-0.8 0.8-1.6 0.8-2.4 1.6-4.8 4-9.6 6.4-14.4 8.8l-3.2 1.6H656c-5.6-3.2-10.4-7.2-15.2-10.4-1.6-1.6-3.2-3.2-5.6-4.8l-2.4-1.6c-8.8-8-12-16.8-13.6-30.4-0.8-4-6.4-48.8-8-58.4 0-0.8-0.8-1.6-0.8-3.2 0-4 3.2-8 7.2-8.8 8.8-0.8 8.8-0.8 16.8 67.2 1.6 12.8 4 16.8 8 20.8l2.4 2.4c1.6 1.6 3.2 2.4 4 4 5.6 4 9.6 7.2 16 11.2 4.8 2.4 12 10.4 11.2 17.6 0 4.8-3.2 8-7.2 10.4-0.8 0.8-2.4 0.8-3.2 0.8l-312-1.6zM992 712.8c-4.8 0-8-3.2-8-8V124c0-10.4-8-18.4-17.6-18.4H57.6c-9.6 0-17.6 8-17.6 18.4v581.6c0 4.8-3.2 8-8 8s-8-3.2-8-8V124c0-19.2 15.2-34.4 33.6-34.4h908c18.4 0 33.6 15.2 33.6 34.4v581.6c0.8 4-2.4 7.2-7.2 7.2z" fill="#6A576D"></path><path d="M940 660.8h-856c-4.8 0-8-3.2-8-8V149.6c0-4.8 3.2-8 8-8h856c4.8 0 8 3.2 8 8v503.2c0 4.8-4 8-8 8z m-848-16h840V157.6h-840v487.2zM966.4 811.2H57.6c-18.4 0-33.6-15.2-33.6-34.4V704c0-4.8 3.2-8 8-8h960c4.8 0 8 3.2 8 8v72.8c0 19.2-15.2 34.4-33.6 34.4zM40 712v64.8c0 10.4 8 18.4 17.6 18.4h908c9.6 0 17.6-8 17.6-18.4V712H40z" fill="#6A576D"></path></g></svg>

                        <span class="mt-1 text-gray-800 text-[11px] font-medium">PC問い合わせ</span>
                    </a>


                </li>
                {{-- <a href="{{ route('suggestion.index') }}" class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">投書箱</a> --}}







                @if (Auth::check() && Auth::user()->hasRole('admin'))
                <li class="relative group" style="margin-left: 5rem;">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">
                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path style="fill:#00969B;"
                                    d="M496.106,324.207l-52.614-43.331c1.158-8.459,1.725-16.685,1.725-24.877s-0.568-16.417-1.725-24.877 l52.614-43.331c6.311-5.198,7.936-14.169,3.851-21.237l-44.522-77.112c-4.074-7.079-12.666-10.162-20.313-7.279l-63.944,23.953 c-13.156-10.129-27.548-18.432-42.963-24.799l-11.231-67.361C315.648,5.899,308.68,0,300.522,0h-89.043 c-8.159,0-15.126,5.899-16.462,13.958l-11.231,67.361c-15.416,6.367-29.807,14.67-42.963,24.799L76.878,82.165 c-7.624-2.894-16.228,0.2-20.313,7.279l-44.522,77.112c-4.085,7.068-2.46,16.039,3.851,21.237l52.614,43.331 c-1.158,8.459-1.725,16.685-1.725,24.877s0.568,16.417,1.725,24.877l-52.614,43.331c-6.311,5.198-7.936,14.169-3.851,21.237 l44.522,77.112c4.085,7.079,12.7,10.184,20.313,7.279l63.944-23.953c13.156,10.129,27.548,18.432,42.963,24.799l11.231,67.361 c1.332,8.061,8.323,13.958,16.462,13.958h89.043c8.153,0,15.122-5.894,16.462-13.958l11.231-67.361 c15.416-6.367,29.807-14.67,42.964-24.799l63.944,23.953c7.635,2.894,16.228-0.2,20.313-7.279l44.522-77.112 C504.042,338.376,502.417,329.405,496.106,324.207z">
                                </path>
                                <path style="fill:#00969B;"
                                    d="M499.957,345.444l-44.522,77.112c-4.085,7.079-12.678,10.173-20.313,7.279l-63.944-23.953 c-13.156,10.129-27.548,18.432-42.963,24.799l-11.231,67.361c-1.34,8.064-8.309,13.958-16.462,13.958h-43.82V0h43.82 c8.159,0,15.126,5.899,16.462,13.958l11.231,67.361c15.416,6.367,29.807,14.67,42.964,24.799l63.944-23.953 c7.647-2.883,16.239,0.2,20.313,7.279l44.522,77.112c4.085,7.068,2.46,16.039-3.851,21.237l-52.614,43.331 c1.158,8.459,1.725,16.685,1.725,24.877s-0.568,16.417-1.725,24.877l52.614,43.331C502.417,329.405,504.042,338.376,499.957,345.444 z">
                                </path>
                                <path style="fill:#f5d493;"
                                    d="M312.32,322.783v184.331c-3.039,3.039-7.235,4.886-11.798,4.886h-89.043 c-3.929,0-7.58-1.369-10.463-3.695V322.783H312.32z">
                                </path>
                                <path style="fill:#e9b66f;"
                                    d="M312.32,322.783v184.331c-3.039,3.039-7.235,4.886-11.798,4.886H256.69V322.783H312.32z">
                                </path>
                                <path style="fill:#f5de69;"
                                    d="M312.32,147.111v75.498L256.668,256l-55.652-33.391v-75.498 c-40.897,20.836-66.781,62.392-66.783,108.886c-0.001,69.725,56.8,122.405,122.371,122.438 c67.539,0.035,122.498-54.903,122.498-122.435C379.103,209.504,353.218,167.947,312.32,147.111z">
                                </path>
                                <path style="fill:#e6be6f;"
                                    d="M379.103,256c0-46.496-25.886-88.053-66.783-108.889v75.498L256.668,256v122.431 C324.181,378.43,379.103,323.511,379.103,256z">
                                </path>
                            </g>
                        </svg>
                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">管理者専用
                        </span>
                    </a>
                </li>
            @endif

            @auth
            @if (auth()->user()->division && auth()->user()->corp->corp_name === '太成HD')
                <li class="relative group">
                    <a href=""
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <img src="{{ asset('logo22.png') }}"
                        alt=""
                        class="w-8 h-8 transition-transform duration-300 transform group-hover:-translate-y-1 mt-1"
                        >

                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">Holdings管理</span>

                    </a>


                    <div
                        class="absolute z-10 hidden bg-white divide-y divide-gray-100 shadow-lg group-hover:block top-full left-0">
                        <a href="{{ route('hr.hr.dashboard') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">申請書(人事)</a>
                        <a href="{{ route('Kintaihr') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">勤怠届(人事)</a>

                        <a href="{{ route('applications2.index') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">社内注文</a>

                        <a href="{{ route('car.index') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">車管理</a>

                        <a href="{{ route('applications2.computer') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">パソコン問い合わせ</a>

                        <a href="{{ route('past-examples.index') }}"
                            class="block px-4 py-2 w-48 hover:bg-sky-500 hover:text-white transition duration-300">問い合わせ事例管理</a>
                    </div>

                </li>
            @endif
        @endauth






                <li class="relative group">
                    <a href="{{ route('myPage.index') }}"
                        class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-gray-100">

                        <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                            height="30px" width="30px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path style="fill:#00969B;"
                                        d="M322.136,353.449v40.41c0,26.994,8.316,48.376,19.501,64.724 c20.229,29.562,49.862,42.647,56.716,42.647c10.647,0,76.221-31.556,76.221-107.37v-40.41c-25.556-7.005-52.292-18.2-76.221-32.328 c-4.434,2.618-8.906,5.117-13.419,7.501C365.002,339.147,344.23,347.395,322.136,353.449z">
                                    </path>
                                    <g>
                                        <path style="fill:#fbfaf9;"
                                            d="M322.136,393.859v-40.41c22.094-6.054,42.866-14.302,62.799-24.827 c-25.893-0.991-45.371-8.564-56.896-39.291c-4.304,2.733-9.113,5.772-14.533,9.449c-38.149,22.027-76.94,21.985-115.012,0.004 c-5.418-3.675-10.23-6.715-14.532-9.453c-17.469,65.191-146.535,22.026-146.535,169.249h218.572l85.639,0.002 C330.452,442.235,322.136,420.853,322.136,393.859z">
                                        </path>
                                        <path style="fill:#fbfaf9;"
                                            d="M198.494,298.784c38.072,21.981,76.864,22.023,115.012-0.004 c5.421-3.677,10.229-6.716,14.531-9.451c24.684-15.709,32.558-21.417,42.157-79.718c1.82-11.067,6.35-31.339,9.016-52.32 c-37.514-1.061-55.779-48.917-55.779-48.917c-55.811,51.647-150.237,21.232-150.237,21.232 c-9.996,16.659-40.404,27.685-40.404,27.685c2.666,20.983,7.195,41.255,9.015,52.32c9.599,58.298,17.475,64.007,42.157,79.72 C188.263,292.068,193.074,295.11,198.494,298.784z">
                                        </path>
                                    </g>
                                    <path style="fill:#565164;"
                                        d="M173.194,129.607c0,0,94.426,30.415,150.237-21.232c0,0,18.265,47.857,55.777,48.917 c2.432-19.143,3.31-38.879-0.835-52.755c-17.786-59.55-66.518-93.763-122.373-93.767c-55.856,0-104.585,34.22-122.375,93.767 c-4.146,13.876-3.267,33.612-0.835,52.755C132.79,157.292,163.197,146.267,173.194,129.607z">
                                    </path>
                                    <g>
                                        <path style="fill:#000003;"
                                            d="M179.47,101.914c1.76,1.081,3.706,1.597,5.632,1.597c3.618,0,7.152-1.822,9.185-5.131 c1.032-1.677,2.129-3.324,3.26-4.892c10.237-14.178,24.463-23.661,41.14-27.424c5.803-1.31,9.444-7.075,8.136-12.877 c-1.311-5.802-7.078-9.446-12.877-8.136c-21.878,4.937-40.504,17.326-53.864,35.829c-1.443,1.998-2.838,4.09-4.145,6.218 C172.821,92.165,174.403,98.798,179.47,101.914z">
                                        </path>
                                        <path style="fill:#000003;"
                                            d="M266.48,64.856c0.044,0.006,0.151,0.02,0.176,0.024c0.467,0.06,0.928,0.089,1.387,0.089 c5.314,0,9.895-3.945,10.614-9.358c0.782-5.879-3.388-11.291-9.267-12.097c-0.179-0.024-0.355-0.046-0.532-0.066 c-5.917-0.625-11.216,3.668-11.838,9.583C256.401,58.906,260.627,64.173,266.48,64.856z">
                                        </path>
                                        <path style="fill:#000003;"
                                            d="M477.421,343.06c-24.938-6.834-51.074-17.918-73.591-31.213c-3.377-1.994-7.572-1.995-10.95,0 c-3.454,2.039-6.921,3.988-10.403,5.871c-18.551-1.1-31.726-6.061-40.95-24.353c22.307-15.171,30.314-27.458,39.293-82.002 c0.56-3.401,1.403-7.8,2.381-12.892c5.367-27.983,13.48-70.272,5.49-97.014c-9.253-30.978-26.81-56.828-50.777-74.755 C314.563,9.235,286.237,0.002,255.999,0c-30.238,0-58.562,9.232-81.914,26.699c-23.967,17.928-41.526,43.777-50.781,74.756 c-7.987,26.734,0.124,69.02,5.491,97.001c0.978,5.099,1.821,9.501,2.382,12.906c9.03,54.841,17.077,66.966,39.661,82.254 c-7.189,13.938-23.255,20.769-47.132,29.948c-21.353,8.209-45.553,17.513-64.549,37.182 c-21.871,22.647-32.502,54.649-32.502,97.835c0,5.948,4.822,10.77,10.77,10.77h218.572h80.129 c4.165,5.519,8.471,10.284,12.587,14.317c17.86,17.5,39.674,28.332,49.639,28.332c9.968,0,31.78-10.833,49.64-28.332 c17.039-16.695,37.35-45.826,37.35-89.808v-40.412C485.345,348.595,482.101,344.342,477.421,343.06z M143.944,107.62 c15.863-53.096,58.8-86.08,112.054-86.08c53.261,0.004,96.198,32.988,112.055,86.081c2.882,9.645,2.935,23.058,1.696,37.119 c-23.512-7.957-36.123-39.86-36.257-40.205c-1.275-3.342-4.126-5.833-7.609-6.647c-3.482-0.812-7.143,0.154-9.768,2.583 c-50.444,46.679-138.744,19.165-139.62,18.885c-4.767-1.536-9.96,0.417-12.537,4.71c-3.803,6.338-13.099,12.648-21.981,17.317 C141.037,128.558,141.292,116.493,143.944,107.62z M152.432,207.863c-0.606-3.683-1.475-8.216-2.481-13.465 c-1.648-8.588-3.686-19.219-5.349-30.333c9.033-4.072,23.313-11.628,32.729-22.1c22.718,5.864,91.819,19.382,142.358-16.687 c7.919,14.053,23.411,35.121,47.352,41.135c-1.594,10.262-3.461,20.014-4.993,27.998c-1.006,5.242-1.874,9.77-2.48,13.451 c-8.945,54.336-14.584,57.923-38.322,73.02c-3.97,2.525-8.457,5.379-13.454,8.759c-17.203,9.87-34.628,14.872-51.795,14.872 c-17.167-0.001-34.59-5.003-51.789-14.868c-4.994-3.38-9.481-6.234-13.449-8.757c-0.34-0.215-0.673-0.429-1.005-0.64 c-0.023-0.014-0.046-0.029-0.069-0.043C166.846,265.669,161.242,261.373,152.432,207.863z M255.999,447.811H48.448 c3.548-73.595,43.903-89.116,82.987-104.142c22.591-8.685,45.82-17.623,57.54-38.296c1.133,0.75,2.289,1.522,3.473,2.324 l0.66,0.414c20.621,11.906,41.779,17.943,62.887,17.944c0,0,0.002,0,0.003,0c21.106,0,42.266-6.039,62.893-17.948l0.659-0.414 c1.314-0.891,2.59-1.742,3.842-2.568c7.582,14.025,17.243,22.352,27.72,27.28c-10.335,4.121-20.905,7.662-31.822,10.653 c-4.68,1.282-7.923,5.535-7.923,10.388v40.412c0,3.885,0.166,7.648,0.467,11.302h-67.02c-5.948,0-10.77,4.822-10.77,10.77 s4.822,10.77,10.77,10.77h70.648c1.994,7.674,4.613,14.7,7.635,21.109h-67.098V447.811z M463.805,393.859 c0,68.166-57.184,94.913-65.451,96.554c-5.197-1.032-29.718-11.989-47.218-36.913c-0.365-0.68-0.802-1.313-1.299-1.896 c-6.822-10.204-12.422-22.641-15.144-37.563c-0.022-0.121-0.039-0.242-0.065-0.362c-1.105-6.179-1.724-12.775-1.724-19.822 v-32.303c19.833-5.968,38.65-13.687,57.008-23.384c0.018-0.01,0.036-0.019,0.055-0.028c2.806-1.484,5.604-3.01,8.391-4.587 c20.601,11.608,42.977,21.177,65.445,27.99v32.312H463.805z">
                                        </path>
                                        <path style="fill:#000003;"
                                            d="M374.291,403.702c-4.206-4.206-11.025-4.206-15.232,0c-4.205,4.206-4.205,11.025,0,15.232 l21.024,21.024c2.103,2.103,4.859,3.155,7.616,3.155c2.756,0,5.513-1.052,7.614-3.155l42.336-42.333 c4.205-4.206,4.206-11.025,0-15.231c-4.205-4.206-11.025-4.206-15.232,0l-34.718,34.717L374.291,403.702z">
                                        </path>
                                        <path style="fill:#000003;"
                                            d="M213.938,405.161h-0.781c-5.948,0-10.77,4.822-10.77,10.77s4.822,10.77,10.77,10.77h0.781 c5.948,0,10.77-4.822,10.77-10.77C224.708,409.983,219.886,405.161,213.938,405.161z">
                                        </path>
                                        <path style="fill:#000003;"
                                            d="M212.813,212.326c7.341,0,13.33-5.987,13.33-13.33s-5.989-13.329-13.33-13.329 c-7.343,0-13.33,5.987-13.33,13.329C199.483,206.339,205.469,212.326,212.813,212.326z">
                                        </path>
                                        <path style="fill:#000003;"
                                            d="M299.194,212.326c7.342,0,13.33-5.987,13.33-13.33s-5.987-13.329-13.33-13.329 c-7.341,0-13.33,5.987-13.33,13.329C285.864,206.339,291.852,212.326,299.194,212.326z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">マイページ</span>
                    </a>
                </li>








                <li class="relative group" >

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex flex-col items-center justify-center w-24 h-16 cursor-pointer bg-white border border-gray-200 hover:bg-red-100">
                            <svg class="transition-transform duration-300 transform group-hover:-translate-y-1"
                                height="30px" width="30px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 297 297" xml:space="preserve" fill="#000000" transform="rotate(180)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="XMLID_42_">
                                        <g>
                                            <path style="fill:#eca7a7;"
                                                d="M176,142c3.59,0,6.5,2.92,6.5,6.5s-2.91,6.5-6.5,6.5H71.5c-3.68,0-7.07,2.03-8.81,5.28 s-1.55,7.2,0.49,10.27L74.82,188H54.85l-26.33-39.5L54.85,109h19.97l-11.64,17.45c-2.04,3.07-2.23,7.02-0.49,10.27 c1.74,3.25,5.13,5.28,8.81,5.28H176z">
                                            </path>
                                            <path style="fill:#fbf9f9;"
                                                d="M270.5,20v257H142V175h34c14.62,0,26.5-11.89,26.5-26.5S190.62,122,176,122h-34V20H270.5z">
                                            </path>
                                            <path
                                                d="M290.5,10v277c0,5.52-4.47,10-10,10H132c-5.52,0-10-4.48-10-10V175H90.19l11.63,17.45c2.05,3.07,2.24,7.02,0.5,10.27 S97.19,208,93.5,208h-44c-3.34,0-6.46-1.67-8.32-4.45l-33-49.5c-2.24-3.36-2.24-7.74,0-11.1l33-49.5C43.04,90.67,46.16,89,49.5,89 h44c3.69,0,7.08,2.03,8.82,5.28s1.55,7.2-0.5,10.27L90.19,122H122V10c0-5.52,4.48-10,10-10h148.5C286.03,0,290.5,4.48,290.5,10z M270.5,277V20H142v102h34c14.62,0,26.5,11.89,26.5,26.5S190.62,175,176,175h-34v102H270.5z M182.5,148.5c0-3.58-2.91-6.5-6.5-6.5 H71.5c-3.68,0-7.07-2.03-8.81-5.28s-1.55-7.2,0.49-10.27L74.82,109H54.85l-26.33,39.5L54.85,188h19.97l-11.64-17.45 c-2.04-3.07-2.23-7.02-0.49-10.27c1.74-3.25,5.13-5.28,8.81-5.28H176C179.59,155,182.5,152.08,182.5,148.5z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="mr-2 mt-1 text-gray-800 text-[11px] font-medium">{{ __('ログアウト') }}</span>
                        </button>
                    </form>

                </li>



                <li class="relative group">
                    <!--notifications-->


                    <a href="{{ route('notifications.index') }}" class="relative flex items-center">
                        <!-- Modified this line -->
                        <svg class="bell-icon w-10 h-10" height="200px" width="200px" version="1.1"
                        id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path style="fill:#FFAA00;"
                                d="M256,100.174c-27.619,0-50.087-22.468-50.087-50.087S228.381,0,256,0s50.087,22.468,50.087,50.087 S283.619,100.174,256,100.174z M256,33.391c-9.196,0-16.696,7.5-16.696,16.696s7.5,16.696,16.696,16.696 c9.196,0,16.696-7.5,16.696-16.696S265.196,33.391,256,33.391z">
                            </path>
                            <path style="fill:#F28D00;"
                                d="M256.006,0v33.394c9.194,0.003,16.69,7.5,16.69,16.693s-7.496,16.69-16.69,16.693v33.394 c27.618-0.004,50.081-22.469,50.081-50.087S283.624,0.004,256.006,0z">
                            </path>
                            <path style="fill:#FFAA00;"
                                d="M256,512c-46.043,0-83.478-37.435-83.478-83.478c0-9.228,7.467-16.696,16.696-16.696h133.565 c9.228,0,16.696,7.467,16.696,16.696C339.478,474.565,302.043,512,256,512z">
                            </path>
                            <path style="fill:#F28D00;"
                                d="M322.783,411.826h-66.777V512c46.042-0.004,83.473-37.437,83.473-83.478 C339.478,419.293,332.011,411.826,322.783,411.826z">
                            </path>
                            <path style="fill:#FFDA44;"
                                d="M439.652,348.113v-97.678C439.642,149,357.435,66.793,256,66.783 C154.565,66.793,72.358,149,72.348,250.435v97.678c-19.41,6.901-33.384,25.233-33.391,47.017 c0.01,27.668,22.419,50.075,50.087,50.085h333.913c27.668-0.01,50.077-22.417,50.087-50.085 C473.036,373.346,459.063,355.014,439.652,348.113z">
                            </path>
                            <path style="fill:#FFAA00;"
                                d="M439.652,348.113v-97.678C439.642,149,357.435,66.793,256,66.783v378.432h166.957 c27.668-0.01,50.077-22.417,50.087-50.085C473.036,373.346,459.063,355.014,439.652,348.113z">
                            </path>
                            <path style="fill:#FFF3DB;"
                                d="M155.826,267.13c-9.228,0-16.696-7.467-16.696-16.696c0-47.022,28.011-89.283,71.381-107.641 c8.446-3.587,18.294,0.326,21.88,8.836c3.62,8.51-0.358,18.294-8.836,21.88c-31.012,13.142-51.033,43.337-51.033,76.925 C172.522,259.663,165.054,267.13,155.826,267.13z">
                            </path>
                        </g>
                    </svg>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                </li>





            </ul>

        </div>
    </div>

    <div id="nav-menu"
        class="fixed inset-0 z-50 bg-gray-800 bg-opacity-100 flex justify-center items-start overflow-y-auto transition-all duration-300 transform translate-x-full">
        <button id="close-menu"
            class="absolute top-4 right-4 text-4xl text-white hover:text-gray-400 focus:outline-none">&times;</button>


        <ul class="flex flex-col items-center space-y-4 w-full max-w-md py-8 px-4">
            <li class="w-full">
                <button onclick="window.location.href='{{ route('dashboard') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">
                   勤退入力
                </button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('myPage.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">
                    マイページ</button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('other') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    勤退情報確認</button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('pdfCompany.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    共有ファイル</button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('warehouse.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    在庫状況</button>
            </li>

            <li class="w-full">
                <button onclick="window.location.href='{{ route('posts.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    投稿</button>
            </li>


            <li class="w-full">
                <button onclick="window.location.href='{{ route('room.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    会議室</button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('actionSchedule.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    行動予定表</button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('companySchedule.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    会社予定表</button>
            </li>

            @if (Auth::check() && Auth::user()->hasRole('admin'))
                <li class="w-full">
                    <button onclick="window.location.href='{{ route('admin.dashboard') }}'"
                        class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                        管理者専用</button>
                </li>
            @endif

            <li class="w-full">
                <button onclick="window.location.href='{{ route('forms.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    各種申請</button>
            </li>

            <li class="w-full">
                <button onclick="window.location.href='{{ route('applications.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    申請履歴</button>
            </li>
            <li class="w-full">
                <button onclick="window.location.href='{{ route('namecards.index') }}'"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                    namecard</button>
            </li>


            @if (auth()->user()->is_boss)
                <li class="w-full">
                    <button onclick="window.location.href='{{ route('applications.boss_index') }}'"
                        class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                        承認</button>
                </li>

                <li class="w-full">
                    <button onclick="window.location.href='{{ route('time_off_boss.index') }}'"
                        class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                        勤怠届(上司)</button>
                </li>


            @endif

            @if (auth()->user()->division && auth()->user()->division->name === '人事課')
                <li class="w-full">
                    <button onclick="window.location.href='{{ route('hr.hr.dashboard') }}'"
                        class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                        申請管理</button>
                </li>
            @endif
            @if (auth()->user()->division && auth()->user()->division->name === '経理課')
                <li class="w-full">
                    <button onclick="window.location.href='{{ route('ac.ac_dashboard') }}'"
                        class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-sky-700 rounded-lg transition duration-300">

                        経理課</button>
                </li>
            @endif


            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="w-full text-sm sm:text-base text-white py-3 px-6 bg-gray-700 hover:bg-red-400 rounded-lg transition duration-300"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('ログアウト') }}
                </button>
            </form>


        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navMenu = document.getElementById('nav-menu');
            const closeMenu = document.getElementById('close-menu');
            const menuToggle = document.getElementById('menu-toggle');

            menuToggle.addEventListener('click', function() {
                navMenu.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            });

            closeMenu.addEventListener('click', function() {
                navMenu.classList.add('translate-x-full');
                document.body.style.overflow = '';
            });
        });
    </script>



    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const navMenu = document.getElementById('nav-menu');
            const closeMenu = document.getElementById('close-menu');

            menuToggle.addEventListener('click', function() {
                navMenu.classList.add('active');
            });

            closeMenu.addEventListener('click', function() {
                navMenu.classList.remove('active');
            });
        });


        // const navToggle = document.getElementById('navToggle');
        // const dropdownMenu = document.getElementById('dropdownMenu');

        // navToggle.addEventListener('click', () => {
        //     dropdownMenu.classList.toggle('show');
        // });



        const dropdownMenus = document.querySelectorAll('.relative');

        dropdownMenus.forEach((menu) => {
            const dropdownToggle = menu.querySelector('.flex');
            const dropdownMenu = menu.querySelector('div:last-child');
            const arrow = menu.querySelector('svg');

            dropdownToggle.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate');
            });

            // menu.addEventListener('mouseleave', () => {
            //     dropdownMenu.classList.add('hidden');
            //     arrow.classList.remove('rotate');
            // });
        });

        // window.addEventListener('click', (e) => {
        //     dropdownMenus.forEach((menu) => {
        //         const dropdownMenu = menu.querySelector('div:last-child');
        //         const target = e.target;

        //         if (!menu.contains(target)) {
        //             dropdownMenu.classList.add('hidden');
        //             menu.querySelector('svg').classList.remove('rotate');
        //         }
        //     });
        // });
    </script> --}}


</body>

</html>
