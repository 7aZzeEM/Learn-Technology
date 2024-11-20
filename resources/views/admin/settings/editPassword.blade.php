@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/settings/password.js')

<script>
    window.token = '{{ csrf_token() }}';
</script>

@endsection