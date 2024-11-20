@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/watch.js')

<script>
    window.videos = @json(json_decode($videos));
    window.course = '{{ $Course }}'
</script>

@endsection
