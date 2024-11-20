@extends('layout.app')

@section('content')

@vite('resources/js/JScomponents/admin/login.js')


<script>
    window.token = '{{ csrf_token() }}';
</script>

@endsection