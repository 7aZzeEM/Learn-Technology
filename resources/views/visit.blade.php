@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/visit.js')

<script>
    window.id = {{ $ID }};
    window.otherUser = @json(json_decode($Visit));
</script>

@endsection