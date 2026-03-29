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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css" />

  <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.colVis.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.min.css" />

  <script src="https://cdn.datatables.net/responsive/3.0.8/js/dataTables.responsive.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.8/css/responsive.dataTables.min.cs">

  {{-- place in end --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-[#1b1b18] h-dvh">
  <x-dashboard.main>
    {{ $slot }}
  </x-dashboard.main>

  <script>
    var debounceTimer;
    var hasErrors = {{ $errors->any() ? 'true' : 'false' }};
    const btnSave = $('#btnSave');
    const btnEdit = $('#btnEdit');
    const btnCancel = $('#btnCancel');
    const btnLoading = $('.btnLoading');

    @if ($errors->has('error'))
      Swal.fire({
        icon: "error",
        title: '{{ $errors->first('error') }}',
      });
    @endif

    $('#form').on('submit', function() {
      blockButtons();
    });

    if (hasErrors) {
      unblockButtons();
    }

    function blockButtons() {
      btnSave.prop('disabled', true).addClass('opacity-60 cursor-not-allowed');
      btnEdit.prop('disabled', true).addClass('opacity-60 cursor-not-allowed');
      btnCancel.addClass('pointer-events-none opacity-50');
      btnLoading.removeClass('hidden');
    }

    function unblockButtons() {
      btnSave.prop('disabled', false).removeClass('opacity-100 cursor-auto');
      btnEdit.prop('disabled', false).removeClass('opacity-100 cursor-auto');
      btnCancel.removeClass('pointer-events-auto opacity-100');
      btnLoading.addClass('hidden');
    }

    unblockButtons();
  </script>
</body>

</html>
