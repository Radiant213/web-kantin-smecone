@extends('layouts.app')

@if(isset($header))
    @section('title')
        {{ strip_tags($header) }}
    @endsection
@endif

@section('content')
    @if(isset($header))
        <div class="bg-white border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                {{ $header }}
            </div>
        </div>
    @endif

    {{ $slot }}
@endsection
