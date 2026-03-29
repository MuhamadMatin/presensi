<x-app-layout>
  <div class="max-w-5xl mx-auto py-8 px-4">
    <div class="mb-6">
      <h1 class="text-base font-semibold text-gray-800">Tambah Presensi</h1>
      <p class="text-xs text-gray-400 mt-0.5">Isi data presensi dan lampirkan foto bukti</p>
    </div>

    <form method="POST" action="{{ route('presences.store') }}" enctype="multipart/form-data" id="form"
      class="border-gray-200 rounded-xl shadow-sm overflow-hidden px-5 py-5 grid grid-cols-1 md::grid-cols-2 gap-4">
      @csrf

      <div class="w-full col-span-2 flex flex-col md:flex-row gap-4">
        {{-- Status --}}
        <div class="w-full">
          <label for="status" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
            Status
          </label>
          <select id="status" name="status" required
            class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400 cursor-pointer">
            <option disabled>Pilih status</option>
            @foreach ($statuses as $status)
              <option value="{{ $status->id_status }}" {{ old('status') === $status->id_status ? 'selected' : '' }}>
                {{ $status->name }}
              </option>
            @endforeach
          </select>
          @error('status')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Lokasi --}}
        <div class="w-full">
          <label for="lokasi" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
            Lokasi
          </label>
          <div class="relative">
            <button type="button" id="btn-detect-location" title="Deteksi lokasi otomatis"
              class="absolute inset-y-0 left-3 flex items-center text-gray-400 hover:text-indigo-500 transition-colors focus:outline-none">
              <svg id="loc-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <svg id="loc-spin" class="w-4 h-4 hidden animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                  stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
              </svg>
            </button>
            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="DSM"
              class="w-full pl-9 pr-3.5 py-2.5 text-sm text-gray-800 bg-white border rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150 border-gray-400" />
          </div>
          @error('lokasi')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Deskripsi --}}
      <div class="col-span-2">
        <label for="deskripsi" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Deskripsi <span class="normal-case text-gray-300">(opsional)</span>
        </label>
        <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Tambahkan catatan jika diperlukan..."
          class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-white border border-gray-400 rounded-lg placeholder-gray-300 resize-none focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Foto --}}
      <div class="col-span-2">
        <label class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
          Foto <span class="normal-case text-gray-300">(maks. 3 foto · JPG/PNG · 2MB)</span>
        </label>
        <input id="foto-input" type="file" name="foto[]" accept="image/jpeg,image/png,image/jpg" multiple
          class="w-full text-sm text-gray-500 border border-gray-400 rounded-lg cursor-pointer file:mr-3 file:py-2 file:px-4 file:border-0 file:rounded-l-lg file:text-sm file:font-medium file:cursor-pointer file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition duration-150" />
        @error('foto')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
        @error('foto.*')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror

        {{-- Preview --}}
        <div id="foto-preview" class="flex gap-2 mt-2.5 flex-wrap"></div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center justify-end gap-3 pb-4 col-span-2">
        <a href="{{ route('presences.index') }}" id="btnCancel"
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
          Simpan Presensi
        </button>
      </div>
    </form>
  </div>

  <script>
    $(function() {
      $('#foto-input').on('change', function() {
        $('#foto-preview').empty();
        $.each(this.files, function(i, file) {
          const url = URL.createObjectURL(file);
          $('#foto-preview').append(
            $('<img>').attr('src', url).addClass('w-20 h-20 object-cover rounded-lg border border-gray-200')
          );
        });
      });

      $('#btn-detect-location').on('click', function() {
        if (!navigator.geolocation) {
          Swal.fire({
            icon: "error",
            title: 'Browser tidak mendukung geolocation.'
          });
          return;
        }
        $('#loc-icon').addClass('hidden');
        $('#loc-spin').removeClass('hidden');
        navigator.geolocation.getCurrentPosition(
          function(pos) {
            $('#lokasi').val('Lat: ' + pos.coords.latitude.toFixed(6) + ', Lng: ' + pos.coords.longitude
              .toFixed(6));
            $('#loc-icon').removeClass('hidden');
            $('#loc-spin').addClass('hidden');
          },
          function() {
            Swal.fire({
              icon: "error",
              title: 'Gagal mendapatkan lokasi.'
            });
            $('#loc-icon').removeClass('hidden');
            $('#loc-spin').addClass('hidden');
          }
        );
      });
    });
  </script>
</x-app-layout>
