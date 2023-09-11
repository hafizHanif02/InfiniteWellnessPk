<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title . ' | ' . config('app.name') ?? '' }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
</head>

<body
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed">
    <div class="d-flex flex-column flex-root">
        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed authImage">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
