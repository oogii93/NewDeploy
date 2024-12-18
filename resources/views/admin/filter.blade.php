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
    <a href="{{ route('admin.download.csv', ['corps_id' => $corpId, 'office_id' => $officeId, 'year' => $selectedYear, 'month' => $selectedMonth]) }}" class="bg-orange-100 hover:bg-orange-200 text-black font-bold py-2 px-4 rounded inline-block mr-2 mb-2">Download CSV by Day</a>
    {{-- <a href="" class="bg-teal-100 hover:bg-teal-200 text-black font-bold py-2 px-4 rounded inline-block mr-2 mb-2">Download CSV by month</a> --}}
    {{-- <a href="{{ route('admin.download.pdf') }}" class="bg-red-100 hover:bg-red-200 text-black font-bold py-2 px-4 rounded inline-block mr-2 mb-2">Download PDF</a>
    <a href="{{ route('admin.download.excel') }}" class="bg-green-100 hover:bg-green-200 text-black font-bold py-2 px-4 rounded inline-block mr-2 mb-2">Download Excel</a> --}}

{{-- {{ route('download.excel') }} --}}
</div>
    <div class="flex flex-wrap">

        @foreach ($users as $user)
        <div class="p-3">
                @include('admin.csv.table', ['user' => $user])
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{-- {{ $users->links() }} --}}
    </div>

    @endsection

