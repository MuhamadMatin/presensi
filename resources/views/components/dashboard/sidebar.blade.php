<div id="sidebar"
  class="fixed top-14 bottom-0 left-0 md:relative md:top-auto md:bottom-auto w-64 shrink-0 bg-white border-r border-gray-200 z-40 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col overflow-y-auto">

  {{-- profile --}}
  <div class="sticky top-0 bg-white px-4 py-4 border-b border-gray-100 shrink-0 z-10">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center shrink-0">
        <svg class="w-4 h-4 stroke-2 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>
      </div>
      <div class="flex justify-between w-full items-center">
        <a href="{{ route('profile') }}">
          <span class="truncate">
            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
            <p class="text-xs text-gray-400">{{ auth()->user()->role->name }}</p>
          </span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
            class="text-red-500 hover:text-red-700 transition-colors focus:outline-none cursor-pointer" title="Logout">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- item nav --}}
  <nav class="flex flex-col gap-0.5 px-3 py-4">
    <a href="{{ route('index') }}"
      class="{{ request()->routeIs('index') ? 'bg-indigo-50 text-indigo-600 font-medium text-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800 text-sm transition-colors duration-150' }} flex items-center gap-3 px-3 py-2 rounded-lg"">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      Dashboard
    </a>

    <a href="{{ route('presences.index') }}"
      class="{{ request()->routeIs('presences.*') ? 'bg-indigo-50 text-indigo-600 font-medium text-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800 text-sm transition-colors duration-150' }} flex items-center gap-3 px-3 py-2 rounded-lg">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
      </svg>
      Presensi
    </a>

    {{-- <a href="#"
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-800 text-sm transition-colors duration-150">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    Reports
  </a> --}}
    @role('Admin|admin')
      <div class="my-3 border-t border-gray-100"></div>
      <p class="px-3 mb-1 text-xs font-semibold uppercase tracking-widest text-gray-400">User</p>

      <a href="{{ route('users.index') }}"
        class="{{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-600 font-medium text-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800 text-sm transition-colors duration-150' }} flex items-center gap-3 px-3 py-2 rounded-lg">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Users
      </a>
      <a href="{{ route('roles.index') }}"
        class="{{ request()->routeIs('roles.*') ? 'bg-indigo-50 text-indigo-600 font-medium text-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800 text-sm transition-colors duration-150' }} flex items-center gap-3 px-3 py-2 rounded-lg">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
        </svg>
        Roles
      </a>

      <div class="my-3 border-t border-gray-100"></div>
      <p class="px-3 mb-1 text-xs font-semibold uppercase tracking-widest text-gray-400">System</p>

      <a href="{{ route('settings.index') }}"
        class="{{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-600 font-medium text-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800 text-sm transition-colors duration-150' }} flex items-center gap-3 px-3 py-2 rounded-lg">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Settings
      </a>
    @endrole
  </nav>
</div>
