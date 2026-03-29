<header
  class="fixed top-0 left-0 right-0 z-50 flex items-center gap-3 bg-white border-b border-gray-200 px-4 h-14 shrink-0">
  {{-- toggle icon --}}
  <button id="sidebarToggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none"
    aria-label="Toggle sidebar">
    {{-- open icon --}}
    <svg id="iconOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    {{-- close icon --}}
    <svg id="iconClose" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>

  <div class="flex items-center gap-2.5">
    <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center shrink-0">
      @if (session('logo'))
        <img class="object-cover rounded-sm" src="{{ Storage::url(session('logo')) }}" alt="logo">
      @else
        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
          <path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" />
          <path d="M14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
        </svg>
      @endif
    </div>
    <p class="text-sm font-semibold text-gray-800 tracking-wide">{{ session('name') }}</p>
  </div>
</header>
