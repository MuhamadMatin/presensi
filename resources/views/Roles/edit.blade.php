<x-app-layout>
  <div class="max-w-5xl mx-auto py-8 px-4">

    <div class="mb-6">
      <h1 class="text-base font-semibold text-gray-800">Update Role</h1>
      <p class="text-xs text-gray-400 mt-0.5">Update data Role</p>
    </div>

    <form method="POST" action="{{ route('roles.update', $role->id_role) }}" id="form"
      class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden px-5 py-5 grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      @method('PUT')

      <div class="col-span-2 md:col-span-1">
        <label for="nama" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Nama
        </label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') ?? $role->name }}" required
          placeholder="Nama role"
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400 cursor-pointer" />
        @error('nama')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Deskripsi --}}
      <div class="col-span-2">
        <label for="deskripsi" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Deskripsi <span class="normal-case text-gray-300">(opsional)</span>
        </label>
        <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Tambahkan catatan jika diperlukan..."
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border border-gray-400 rounded-lg placeholder-gray-300 resize-none focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150">{{ old('deskripsi') ?? $role->description }}</textarea>
        @error('deskripsi')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div class="col-span-2 flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('roles.index') }}" id="btnCancel"
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
          Update Role
        </button>
      </div>
    </form>
  </div>
</x-app-layout>
