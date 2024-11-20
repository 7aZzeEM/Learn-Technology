@extends('layout.app')

@section('content')
<div id="head">
    @vite('resources/js/JScomponents/app/bar.js')
</div>
<div id="container" class="d-flex m-0">
    <aside>
        @vite('resources/js/JScomponents/app/aside.js')
    </aside>
    <script>
        window.user = {
            id: {{ $User->id }},
            image: '{{ $User->photo }}',
            first_name: '{{ $User->first_name }}',
            last_name: '{{ $User->last_name }}',
            email: '{{ $User->email }}',
            phone: '{{ $User->phone }}',
            photo: '{{ $User->photo }}',
            courses_sub: @json(json_decode($User->courses_sub)),
            courses_end: @json(json_decode($User->courses_end)),
            category: '{{ $User->category }}',
            links: @json(json_decode($User->links)),
            projects: @json(json_decode($User->projects))
        };
    </script>
    <main style="flex: 3.5">
        @yield('content2')
    </main>
</div>
@if($errors->any())
    @php
        $arrErr = [];
    @endphp
    @foreach ($errors->all() as $error)
        @php
            $arrErr[] = $error;
        @endphp
    @endforeach
    <script>
        window.errors = @json(json_encode($arrErr))
    </script>
@endif

@if(session('message'))
    <script>
        window.message = '{{ session('message') }}'
    </script>
@endif

@if(session('done'))
    <script>
        window.done = '{{ session('done') }}'
    </script>
@endif

@endsection