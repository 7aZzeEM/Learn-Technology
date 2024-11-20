@extends('layout.app')

@section('content')
@vite('resources/js/JScomponents/index.js')
<script>
    window.token = {
        csrftoken: '{{ csrf_token() }}'
    };
</script>
@endsection