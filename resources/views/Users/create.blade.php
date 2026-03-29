<x-app-layout>
  <div class="max-w-5xl mx-auto py-8 px-4">

    <div class="mb-6">
      <h1 class="text-base font-semibold text-gray-800">Tambah User</h1>
      <p class="text-xs text-gray-400 mt-0.5">Isi data pengguna baru</p>
    </div>

    <form method="POST" action="{{ route('users.store') }}" id="form"
      class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden px-5 py-5 grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf

      <div class="col-span-2 md:col-span-1">
        <label for="nama" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Nama
        </label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
          placeholder="Nama lengkap"
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400 cursor-pointer" />
        @error('nama')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Username --}}
      <div class="col-span-2 md:col-span-1">
        <label for="username" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Username
        </label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required
          placeholder="username"
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400" />
        @error('username')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Email --}}
      <div class="col-span-2 md:col-span-1">
        <label for="email" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Email
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm pointer-events-none">@</span>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
            placeholder="email@contoh.com"
            class="w-full pl-7 pr-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400" />
        </div>
        @error('email')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Phone Number --}}
      <div class="col-span-2 md:col-span-1">
        <label for="phone_number" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Nomor Telepon
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </span>
          <input type="number" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
            placeholder="08xxxxxxxxxx"
            class="w-full pl-9 pr-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400"
            required />
        </div>
        @error('phone_number')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Role --}}
      <div class="col-span-2 md:col-span-1">
        <label for="role" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Role
        </label>
        <select id="role" name="role" required
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg cursor-pointer focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400">
          <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
          @foreach ($roles as $role)
            <option value="{{ $role->id_role }}" {{ old('role') == $role->id_role ? 'selected' : '' }}>
              {{ $role->name }}
            </option>
          @endforeach
        </select>
        @error('role')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div class="col-span-2 flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('users.index') }}" id="btnCancel"
          class="px-4 py-2 text-sm text-red-500 hover:text-red-700 border border-red-200 rounded-lg hover:bg-red-50 transition duration-150 focus:outline-none cursor-pointer">
          Batal
        </a>
        <button type="submit" id="btnSave"
          class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 flex items-center gap-2 cursor-pointer">
          <span class="btnLoading hidden w-5 h-5 stroke-white">
            <svg viewBox="0 0 50 50">
              <circle cx="25" cy="25" r="20" fill="none" stroke="" stroke-width="3"
                stroke-linecap="round" stroke-dasharray="60 120">
                <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s"
                  repeatCount="indefinite"></animateTransform>
              </circle>
            </svg>
          </span>
          Simpan User
        </button>
      </div>
    </form>
  </div>
</x-app-layout>
