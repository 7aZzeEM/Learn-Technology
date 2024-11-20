@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/editphone.js')

<script>
    window.token = {
        csrftoken: '{{ csrf_token() }}'
    };
</script>

@endsection