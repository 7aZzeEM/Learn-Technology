@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/editpass.js')

<script>
    window.token = {
        csrftoken: '{{ csrf_token() }}'
    };
</script>

@endsection