@extends('layout.app')

@section('content')

<div id="head">
    @vite('resources/js/JScomponents/admin/header/header.js')
</div>

<div id="container">
    @yield('container')
</div>

@endsection