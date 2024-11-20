@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/settings/phone.js')

<script>
    window.admin = @json($Admin);
    window.token = '{{ csrf_token() }}';
</script>

@endsection