@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/settings/email.js')

<script>
    window.admin = @json($Admin);
    window.token = '{{ csrf_token() }}';
</script>

@endsection