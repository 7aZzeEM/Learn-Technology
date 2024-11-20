@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/courses.js')

<script>
    window.courses = @json(json_encode($courses));
</script>

@endsection