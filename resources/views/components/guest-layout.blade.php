<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ session('name') ?? config('app.name') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  <link rel="icon" href="{{ Storage::url('favicon.ico') ?? '/favicon.ico' }}" type="image/x-icon">

  <script src="https://code.jquery.com/jquery-4.0.0.min.js"
    integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-4.0.0.module.min.js"
    integrity="sha256-d4LwM9D6pTkixVQVP66nz3BYd8ri7Uriz7C3X4qBAVE=" crossorigin="anonymous"></script>

  {{-- place in end --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-[#1b1b18]">
  {{ $slot }}
</body>

</html>
