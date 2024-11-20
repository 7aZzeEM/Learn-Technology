@extends('admin.layout.web')

@section('container')

@vite('resources/js/JScomponents/admin/admin.js')

<script>
    window.admins = @json($Admins);
    window.admin = @json($Admin);
    window.per = {{ $Admin->powers }};
</script>

@endsection