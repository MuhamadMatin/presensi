<x-app-layout>
  <div class="max-w-5xl mx-auto py-8 px-4">

    {{-- ── HEADER ── --}}
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-base font-semibold text-gray-800">Dashboard</h1>
        <p class="text-xs text-gray-400 mt-0.5">{{ now()->translatedFormat('d F Y') }}</p>
      </div>
      @if (!$is_presence_today)
        <a href="{{ route('presences.create') }}"
          class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg
                 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 cursor-pointer">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Presensi Masuk
        </a>
      @elseif ($is_presence_today->entry !== null && $is_presence_today->out !== null)
        <p
          class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg cursor-default">
          Anda sudah presensi keluar
        </p>
      @else
        <form method="POST" action="{{ route('presences.out') }}">
          @csrf
          @method('PATCH')
          <button type="submit" id="btnPresenceOut"
            class="flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500/40 transition duration-150 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Presensi Keluar
          </button>
        </form>
      @endif
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
      <div class="border border-gray-200 rounded-xl shadow-sm px-4 py-4">
        <div class="flex items-center justify-between mb-3">
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Hadir</p>
          <span class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </span>
        </div>
        <p id="presentToday" class="text-2xl font-bold text-gray-800">0</p>
        <p class="text-xs text-gray-400 mt-0.5">hari ini</p>
      </div>

      <div class="border border-gray-200 rounded-xl shadow-sm px-4 py-4">
        <div class="flex items-center justify-between mb-3">
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Izin</p>
          <span class="w-7 h-7 rounded-lg bg-yellow-50 flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
            </svg>
          </span>
        </div>
        <p id="leaveToday" class="text-2xl font-bold text-gray-800">0</p>
        <p class="text-xs text-gray-400 mt-0.5">hari ini</p>
      </div>

      <div class="border border-gray-200 rounded-xl shadow-sm px-4 py-4">
        <div class="flex items-center justify-between mb-3">
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Sakit</p>
          <span class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
          </span>
        </div>
        <p id="sickToday" class="text-2xl font-bold text-gray-800">0</p>
        <p class="text-xs text-gray-400 mt-0.5">hari ini</p>
      </div>

      <div class="border border-gray-200 rounded-xl shadow-sm px-4 py-4">
        <div class="flex items-center justify-between mb-3">
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Cuti</p>
          <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </span>
        </div>
        <p id="dayOffToday" class="text-2xl font-bold text-gray-800">0</p>
        <p class="text-xs text-gray-400 mt-0.5">hari ini</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
      <div class="lg:col-span-2 flex flex-col gap-5">
        {{-- Newest presences --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <p class="text-sm font-semibold text-gray-800">Presensi Terbaru</p>
            <a href="{{ route('presences.index') }}"
              class="text-xs text-indigo-500 hover:text-indigo-700 font-medium transition-colors">
              Lihat semua →
            </a>
          </div>
          <div id="recentPresenceList" class="divide-y divide-gray-100">
            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
              <svg viewBox="0 0 50 50" class="w-6 h-6 mb-2 animate-spin stroke-gray-400">
                <circle cx="25" cy="25" r="20" fill="none" stroke="" stroke-width="3"
                  stroke-linecap="round" stroke-dasharray="60 120">
                  <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25"
                    dur="1s" repeatCount="indefinite"></animateTransform>
                </circle>
              </svg>
              <p class="text-xs">Memuat data...</p>
            </div>
          </div>
        </div>

        @role('Admin')
          <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
              <div>
                <p class="text-sm font-semibold text-gray-800">Rekap Bulanan</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ now()->translatedFormat('F Y') }} — semua karyawan</p>
              </div>
            </div>
            <div class="px-5 py-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
              <div class="text-center bg-green-50 rounded-lg py-3">
                <p id="presentMonthAll" class="text-lg font-bold text-green-600">0</p>
                <p class="text-xs font-semibold text-green-500 uppercase tracking-widest mt-0.5">Hadir</p>
              </div>
              <div class="text-center bg-yellow-50 rounded-lg py-3">
                <p id="leaveMonthAll" class="text-lg font-bold text-yellow-600">0</p>
                <p class="text-xs font-semibold text-yellow-500 uppercase tracking-widest mt-0.5">Izin</p>
              </div>
              <div class="text-center bg-red-50 rounded-lg py-3">
                <p id="sickMonthAll" class="text-lg font-bold text-red-600">0</p>
                <p class="text-xs font-semibold text-red-500 uppercase tracking-widest mt-0.5">Sakit</p>
              </div>
              <div class="text-center bg-blue-50 rounded-lg py-3">
                <p id="dayOffMonthAll" class="text-lg font-bold text-blue-600">0</p>
                <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mt-0.5">Cuti</p>
              </div>
            </div>
          </div>
        @endrole
      </div>

      <div class="flex flex-col gap-5">
        {{-- Today presence --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
          <div class="flex items-center">
            <div class="px-5 py-4 border-b border-gray-100">
              <p class="text-sm font-semibold text-gray-800">Presensi Saya</p>
              <p class="text-xs text-gray-400 mt-0.5">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
            <span id="myStatusBadge"
              class="px-2.5 py-1 rounded-full text-xs font-semibold
                  {{ $is_presence_today?->status?->name === 'Hadir' ? 'bg-green-50 text-green-600' : '' }}
                  {{ in_array($is_presence_today?->status?->name, ['Izin', 'Sakit']) ? 'bg-yellow-50 text-yellow-600' : '' }}
                  {{ $is_presence_today?->status?->name === 'Cuti' ? 'bg-blue-50 text-blue-600' : '' }}">
              {{ $is_presence_today->status?->name ?? '-' }}
            </span>
          </div>
          <div class="px-5 py-4" id="myPresenceTodayBlock">

            @if ($is_presence_today)
              <div class="grid grid-cols-2 gap-3">
                <div class="bg-gray-50 rounded-lg px-3 py-2.5">
                  <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Masuk</p>
                  <p id="myEntryTime" class="text-sm font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($is_presence_today->entry)->format('H:i') ?? '-' }}
                  </p>
                </div>
                <div class="bg-gray-50 rounded-lg px-3 py-2.5">
                  <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Keluar</p>
                  <p id="myOutTime" class="text-sm font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($is_presence_today->out)->format('H:i') ?? '-' }}
                  </p>
                </div>
              </div>

              @if ($is_presence_today->description)
                <p class="text-xs text-gray-400 mt-3 line-clamp-2">{{ $is_presence_today->description }}</p>
              @endif
            @else
              <div class="flex flex-col items-center py-4 text-center">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <p class="text-sm text-gray-500 font-medium">Belum presensi</p>
                <p class="text-xs text-gray-400 mt-0.5">Anda belum melakukan presensi hari ini</p>
                <a href="{{ route('presences.create') }}"
                  class="mt-3 px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition duration-150">
                  Presensi Masuk
                </a>
              </div>
            @endif
          </div>
        </div>

        {{-- Recap monthly --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
          <div class="px-5 py-4 border-b border-gray-100">
            <p class="text-sm font-semibold text-gray-800">Rekap Saya</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ now()->translatedFormat('F Y') }}</p>
          </div>
          <div class="px-5 py-4 grid grid-cols-2 gap-3">
            <div class="text-center bg-green-50 rounded-lg py-3">
              <p id="presentMonth" class="text-lg font-bold text-green-600">0</p>
              <p class="text-xs font-semibold text-green-500 uppercase tracking-widest mt-0.5">Hadir</p>
            </div>
            <div class="text-center bg-yellow-50 rounded-lg py-3">
              <p id="leaveMonth" class="text-lg font-bold text-yellow-600">0</p>
              <p class="text-xs font-semibold text-yellow-500 uppercase tracking-widest mt-0.5">Izin</p>
            </div>
            <div class="text-center bg-red-50 rounded-lg py-3">
              <p id="sickMonth" class="text-lg font-bold text-red-600">0</p>
              <p class="text-xs font-semibold text-red-500 uppercase tracking-widest mt-0.5">Sakit</p>
            </div>
            <div class="text-center bg-blue-50 rounded-lg py-3">
              <p id="dayOffMonth" class="text-lg font-bold text-blue-600">0</p>
              <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mt-0.5">Cuti</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function getDashboardDatas() {
      $.ajax({
        url: "{{ route('dataPresences') }}",
        type: 'GET',
        success: function(resp) {
          // Stat cards today
          $('#presentToday').text(resp.today_recap.present);
          $('#leaveToday').text(resp.today_recap.leave);
          $('#sickToday').text(resp.today_recap.sick);
          $('#dayOffToday').text(resp.today_recap.day_off);

          // Rekap person month
          $('#presentMonth').text(resp.my_monthly_recap.present);
          $('#leaveMonth').text(resp.my_monthly_recap.leave);
          $('#sickMonth').text(resp.my_monthly_recap.sick);
          $('#dayOffMonth').text(resp.my_monthly_recap.day_off);

          // Rekap all monthly (admin)
          if (resp.monthly_recap) {
            $('#presentMonthAll').text(resp.monthly_recap.present);
            $('#leaveMonthAll').text(resp.monthly_recap.leave);
            $('#sickMonthAll').text(resp.monthly_recap.sick);
            $('#dayOffMonthAll').text(resp.monthly_recap.day_off);
          }

          // Jam masuk/keluar (update realtime setelah presensi keluar)
          if (resp.my_presence_today) {
            $('#myOutTime').text(resp.my_presence_today.out ?
              resp.my_presence_today.out.substring(11, 16) :
              '-'
            );
            $('#myEntryTime').text(resp.my_presence_today.entry ?
              resp.my_presence_today.entry.substring(11, 16) :
              '-'
            );
          }

          // Render presensi terbaru
          var list = resp.recent_presences;
          var html = '';
          if (list.length === 0) {
            html = `<div class="flex flex-col items-center justify-center py-10 text-gray-400">
              <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              <p class="text-sm">Belum ada presensi</p>
            </div>`;
          } else {
            var badgeMap = {
              'Hadir': 'bg-green-50 text-green-600',
              'Izin': 'bg-yellow-50 text-yellow-600',
              'Sakit': 'bg-red-50 text-red-600',
              'Cuti': 'bg-blue-50 text-blue-600',
            };
            list.forEach(function(p) {
              var statusName = p.status ? p.status.name : '-';
              var badgeClass = badgeMap[statusName] || 'bg-gray-100 text-gray-500';
              var userName = p.user ? p.user.name : '-';
              var entryTime = p.entry ? p.entry.substring(11, 16) : '-';
              var entryDate = p.entry ? p.entry.substring(5, 10).replace('-', '/') : '-';
              var location = p.location ? ' · ' + p.location : '';

              html += `<div class="flex items-center gap-3 px-5 py-3">
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-800 truncate">${userName}</p>
                  <p class="text-xs text-gray-400 truncate">${entryTime}${location}</p>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold shrink-0 ${badgeClass}">${statusName}</span>
                <p class="text-xs text-gray-400 shrink-0 hidden sm:block">${entryDate}</p>
              </div>`;
            });
          }
          $('#recentPresenceList').html(html);
        },
        error: function(err) {
          console.log(err);
          $('#recentPresenceList').html(
            '<p class="text-xs text-center text-red-400 py-6">Gagal memuat data.</p>'
          );
        }
      });
    }

    $(document).on('click', '#btnPresenceOut', function(event) {
      event.preventDefault();
      var form = $(this).closest('form');
      $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: {
          _token: form.find('input[name="_token"]').val(),
          _method: 'PATCH'
        },
        success: function(resp) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: resp.message,
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
          getDashboardDatas();
          $('#btnPresenceOut').removeClass('bg-orange-600 hover:bg-orange-700 focus:ring-orange-500/40')
            .addClass('bg-green-600 cursor-default pointer-events-none')
            .text('Anda sudah presensi keluar');
        },
        error: function(xhr) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Terjadi error presensi keluar',
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true,
          });
        }
      });
    });

    getDashboardDatas();
  </script>
</x-app-layout>
