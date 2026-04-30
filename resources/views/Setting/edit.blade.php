<x-app-layout>
  <div class="max-w-5xl mx-auto py-8 px-4">

    <div class="mb-6">
      <h1 class="text-base font-semibold text-gray-800">Update Setting</h1>
      <p class="text-xs text-gray-400 mt-0.5">Update data Setting</p>
    </div>

    <form method="POST" action="{{ route('settings.update', $setting->id_setting) }}" id="form"
      class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden px-5 py-5 grid grid-cols-1 md:grid-cols-2 gap-4"
      enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="col-span-2 md:col-span-1">
        <label for="nama" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Nama
        </label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') ?? $setting->name }}" required
          placeholder="Nama website"
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400" />
        @error('nama')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div class="col-span-2 md:col-auto">
        <label class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Logo <span class="normal-case text-gray-300">(maks 1MB)</span>
        </label>
        <input id="logo-input" type="file" name="logo" accept="image/png"
          class="w-full text-sm text-gray-500 border border-gray-400 rounded-lg cursor-pointer file:mr-3 file:py-2 file:px-4 file:border-0 file:rounded-l-lg file:text-sm file:font-medium file:cursor-pointer file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition duration-150" />
        @error('logo')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror

        {{-- Preview --}}
        <div class="flex gap-2 mt-2.5 flex-wrap">
          <div id="logo-preview"></div>
          @if ($setting->logo)
            <img class="w-20 h-20 object-cover rounded-lg border border-gray-200"
              src="{{ Storage::url($setting->logo) }}" alt="logo presensi" />
          @else
            <p>belum ada logo</p>
          @endif
        </div>
      </div>

      {{-- Deskripsi --}}
      <div class="col-span-2 md:col-auto">
        <label for="deskripsi" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Deskripsi <span class="normal-case text-gray-300">(opsional)</span>
        </label>
        <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Tambahkan catatan jika diperlukan..."
          class="w-full grow px-3.5 py-2.5 text-sm text-gray-800 bg-white border border-gray-400 rounded-lg placeholder-gray-300 resize-none focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150">{{ old('deskripsi') ?? $setting->description }}</textarea>
        @error('deskripsi')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div class="col-span-2 md:col-auto">
        <label for="manifest" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Update Manifest
        </label>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" id="toggle-switch" class="sr-only peer" name="manifest" />
          <div
            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
          </div>
        </label>
      </div>

      <div class="col-span-2 flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('settings.index') }}" id="btnCancel"
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
          Update Setting
        </button>
      </div>

    </form>
  </div>

  <script>
    $(function() {
      $('#logo-input').on('change', function() {
        $('#logo-preview').empty();
        $.each(this.files, function(i, file) {
          const url = URL.createObjectURL(file);
          $('#logo-preview').append(
            $('<img>').attr('src', url).addClass('w-20 h-20 object-cover rounded-lg border border-gray-200')
          );
        });
      });
    });
  </script>
</x-app-layout>
