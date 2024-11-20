@extends('admin.layout.web')

@section('container')

    @vite('resources/js/JScomponents/admin/roadmaps.js')

    <script>
        window.roadmaps = @json(json_encode($Roadmaps));
        window.courses = @json(json_encode($Courses));
    </script>

@endsection