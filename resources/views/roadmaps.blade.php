@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/roadmap.js')

<script>
    window.roadmaps = @json(json_encode($Roadmaps));
</script>

@endsection