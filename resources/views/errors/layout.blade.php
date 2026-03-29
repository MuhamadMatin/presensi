<x-guest-layout>
  <main class="h-full px-6 py-24 sm:py-32 lg:px-8">
    <div class="mt-10 md:flex-row flex-col flex items-center justify-center gap-x-2 md:gap-x-6">
      <p class="text-4xl font-extrabold text-indigo-600">
        @yield('code')
      </p>

      <h1 class="text-2xl text-gray-900 sm:text-3xl uppercase">
        @yield('message')
      </h1>
    </div>

    <div class="flex items-center justify-center gap-x-6 mt-6">
      <a href="{{ route('index') }}"
        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Home
      </a>
    </div>
  </main>
</x-guest-layout>
{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - {{ session('name') ?? config('app.name') }}</title>

  <link rel="icon" href="{{ Storage::url('favicon.ico') }}" type="image/x-icon">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <main class="h-full px-6 py-24 sm:py-32 lg:px-8">
    <div class="mt-10 md:flex-row flex-col flex items-center justify-center gap-x-2 md:gap-x-6">
      <p class="text-4xl font-extrabold text-indigo-600">
        @yield('code')
      </p>

      <h1 class="text-2xl text-gray-900 sm:text-3xl uppercase">
        @yield('message')
      </h1>
    </div>

    <div class="flex items-center justify-center gap-x-6 mt-6">
      <a href="{{ route('index') }}"
        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Home
      </a>
    </div>
  </main>
</body>

</html> --}}
