<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

</head>
<body>
	
    @if(session()->has('message'))
    <div class="container mt-2">
        <div class="row">
            <div class="col-xl-12">
                <div class="alert alert-dismissable alert-{{ session()->get('status') }}">
                    {!! session()->get('message') !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if(isset($errors) && count($errors) > 0)
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="alert alert-dismissable alert-danger">
                    <ul>
                        @foreach (array_unique($errors->all()) as $error)
                            <li class="list-unstyled">{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    
	@yield('content')
    @yield('more_scripts')

</body>
</html>
