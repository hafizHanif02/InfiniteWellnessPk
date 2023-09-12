<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('inventory/css/print.min.css') }}" />
    <link rel="shortcut icon" type="image/ico" href="{{ asset('logo.png') }}" />
</head>

<body>
    {{ $slot }}
</body>

</html>
