@extends('admin.dashboard')

@section('admin')

@php

$currentDate = $startDate->copy();


@endphp

@while ($currentDate <= $endDate)
<!-- Render attendance records for the current date -->
@php
    $currentDate->addDay();
@endphp
@endwhile



<div class="py-2 px-2">
    <form action="{{ route('admin.download1.csv') }}" method="POST" class="inline-block">
        @csrf
        <input type="hidden" name="corps_id" value="{{ $corpId }}">
        <input type="hidden" name="office_id" value="{{ $officeId }}">
        <input type="hidden" name="year" value="{{ $selectedYear }}">
        <input type="hidden" name="month" value="{{ $selectedMonth }}">
        {{-- <button type="submit" class="bg-green-200 hover:bg-green-300 text-black hover:text-white font-bold py-2 px-4 rounded-2xl inline-block  mb-2 mt-2 ml-5">
           CSV出す
        </button> --}}
        <button class="ml-5 px-2 py-2 hover:bg-sky-600 rounded-xl">
            <svg
            class="w-16 h-16"
            version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 303.188 303.188" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <polygon style="fill:#E4E4E4;" points="219.821,0 32.842,0 32.842,303.188 270.346,303.188 270.346,50.525 "></polygon> <polygon style="fill:#007934;" points="227.64,25.263 32.842,25.263 32.842,0 219.821,0 "></polygon> <g> <g> <path style="fill:#A4A9AD;" d="M114.872,227.984c-2.982,0-5.311,1.223-6.982,3.666c-1.671,2.444-2.507,5.814-2.507,10.109 c0,8.929,3.396,13.393,10.188,13.393c2.052,0,4.041-0.285,5.967-0.856c1.925-0.571,3.86-1.259,5.808-2.063v10.601 c-3.872,1.713-8.252,2.57-13.14,2.57c-7.004,0-12.373-2.031-16.107-6.094c-3.734-4.062-5.602-9.934-5.602-17.615 c0-4.803,0.904-9.023,2.714-12.663c1.809-3.64,4.411-6.438,7.808-8.395c3.396-1.957,7.39-2.937,11.98-2.937 c5.016,0,9.808,1.09,14.378,3.27l-3.841,9.871c-1.713-0.805-3.428-1.481-5.141-2.031 C118.681,228.26,116.841,227.984,114.872,227.984z"></path> <path style="fill:#A4A9AD;" d="M166.732,250.678c0,2.878-0.729,5.433-2.191,7.665c-1.459,2.232-3.565,3.967-6.315,5.205 c-2.751,1.237-5.977,1.856-9.681,1.856c-3.089,0-5.681-0.217-7.775-0.65c-2.095-0.434-4.274-1.191-6.538-2.27v-11.172 c2.391,1.227,4.877,2.186,7.458,2.872c2.582,0.689,4.951,1.032,7.109,1.032c1.862,0,3.227-0.322,4.095-0.969 c0.867-0.645,1.302-1.476,1.302-2.491c0-0.635-0.175-1.19-0.524-1.666c-0.349-0.477-0.91-0.958-1.682-1.444 c-0.772-0.486-2.83-1.48-6.173-2.983c-3.026-1.375-5.296-2.708-6.809-3.999s-2.634-2.771-3.364-4.443s-1.095-3.65-1.095-5.936 c0-4.273,1.555-7.605,4.666-9.997c3.109-2.391,7.384-3.587,12.822-3.587c4.803,0,9.7,1.111,14.694,3.333l-3.841,9.681 c-4.337-1.989-8.082-2.984-11.234-2.984c-1.63,0-2.814,0.286-3.555,0.857s-1.111,1.28-1.111,2.127 c0,0.91,0.471,1.725,1.412,2.443c0.941,0.72,3.496,2.031,7.665,3.936c3.999,1.799,6.776,3.729,8.331,5.792 C165.955,244.949,166.732,247.547,166.732,250.678z"></path> <path style="fill:#A4A9AD;" d="M199.964,218.368h14.027l-15.202,46.401H184.03l-15.139-46.401h14.092l6.316,23.519 c1.312,5.227,2.031,8.865,2.158,10.918c0.148-1.481,0.443-3.333,0.889-5.555c0.443-2.222,0.835-3.967,1.174-5.236 L199.964,218.368z"></path> </g> </g> <polygon style="fill:#D1D3D3;" points="219.821,50.525 270.346,50.525 219.821,0 "></polygon> <g> <rect x="134.957" y="80.344" style="fill:#007934;" width="33.274" height="15.418"></rect> <rect x="175.602" y="80.344" style="fill:#007934;" width="33.273" height="15.418"></rect> <rect x="134.957" y="102.661" style="fill:#007934;" width="33.274" height="15.419"></rect> <rect x="175.602" y="102.661" style="fill:#007934;" width="33.273" height="15.419"></rect> <rect x="134.957" y="124.979" style="fill:#007934;" width="33.274" height="15.418"></rect> <rect x="175.602" y="124.979" style="fill:#007934;" width="33.273" height="15.418"></rect> <rect x="94.312" y="124.979" style="fill:#007934;" width="33.273" height="15.418"></rect> <rect x="134.957" y="147.298" style="fill:#007934;" width="33.274" height="15.418"></rect> <rect x="175.602" y="147.298" style="fill:#007934;" width="33.273" height="15.418"></rect> <rect x="94.312" y="147.298" style="fill:#007934;" width="33.273" height="15.418"></rect> <g> <path style="fill:#007934;" d="M127.088,116.162h-10.04l-6.262-10.041l-6.196,10.041h-9.821l10.656-16.435L95.406,84.04h9.624 l5.8,9.932l5.581-9.932h9.909l-10.173,16.369L127.088,116.162z"></path> </g> </g> </g> </g></svg>
            <span class="text-gray-600 hover:text-gray-800 font-semibold text-sm">CSV出す</span>
        </button>
    </form>
</div>
    <div class="flex flex-wrap">

        @foreach ($users as $user)
        <div class="p-3">
                @include('admin.csv.table', [
                    'user' => $user,
                    'startDate'=>$startDate,
                    'endDate'=>$endDate,
                    'holiday'=>$holidays,
                    'corpName'=>$corpName,
                    'breakData'=>$breakData
                    ])
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>

    @endsection
