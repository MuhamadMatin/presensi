<x-guest-layout>
  <div class="max-w-md mx-auto mt-10">
    <a class="text-gray-400 duration-200 hover:text-gray-700" href="{{ route('index') }}">Back to
      Home</a>
    <div class="min-h-screen w-fit">
      <p class="text-xl tracking-wider text-gray-700">
        @yield('code')
      </p>

      <p class="text-2xl tracking-wider text-gray-700 uppercase">
        @yield('message')
      </p>
    </div>
  </div>
</x-guest-layout>
