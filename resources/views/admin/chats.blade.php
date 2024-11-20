@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/chat.js')

<script>
    window.admin = @json($Admin);
</script>

@endsection