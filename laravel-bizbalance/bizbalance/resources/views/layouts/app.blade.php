<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizBalance - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('CSS/dashboardstyle.css') }}?v=1.0">
</head>
<body>
    @include('partials.navbar')

    <div class="dashboard">
        @yield('content')
    </div>
</body>
</html>
