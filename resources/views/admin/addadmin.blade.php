@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/addadmin.js')

<script>
    window.admin = @json($Admin);
    window.token = {
        csrftoken: '{{ csrf_token() }}',
    }
</script>

@endsection