@extends('layouts.appUser')
@section('nav')
<!-- Navigation Links (Right) -->
<!-- Return Frame -->
<div class="border border-gray-200 rounded-lg px-4 py-2 bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
    <a href="/"
        class="text-sm font-medium text-gray-700 flex items-center gap-1">
        <i class="fas fa-arrow-left text-xs"></i>
        Return
    </a>
</div>

@endsection
@section('content')
<div class="container mx-auto p-6">
    @yield('content1')

</div>

@endsection