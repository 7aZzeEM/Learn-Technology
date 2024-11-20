@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/search.js')

<script>
    window.q = '{{ $q }}';
</script>

@endsection