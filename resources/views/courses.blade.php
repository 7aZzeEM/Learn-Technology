@extends('layout.web')

@section('content2')

@vite('resources/js/JScomponents/courses.js')

<script>
    window.courses = @json(json_decode($Courses));
</script>

@endsection