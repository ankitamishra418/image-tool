<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon/img.png') }}" />
    <title>XTeam Image Tools</title>
    @include('frontend.include.head-link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #dropArea {
            cursor: pointer;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: .3s;
        }

        #dropArea.border-primary {
            border-color: #0d6efd !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    @include('frontend.include.header')
    @yield('content')
    @include('frontend.include.footer')
    @include('frontend.include.footer-link')
</body>

</html>