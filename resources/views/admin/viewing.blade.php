@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/visit.js')

<script>
    window.user = @json(json_encode($User));
</script>

@endsection