@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/users.js')

<script>
    window.users = @json(json_encode($Users));
</script>

@endsection