<x-app-layout>
  <div class="max-w-5xl mx-auto py-8 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        {{-- Avatar --}}
        <div class="flex items-center gap-4 px-6 py-5 border-b border-gray-100">
          <div
            class="w-12 h-12 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 stroke-2 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
          </div>
          <div class="min-w-0">
            <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ auth()->user()->role->name }}</p>
          </div>
        </div>

        {{-- Form profil --}}
        <form method="POST" action="{{ route('updateProfil', $user->id_user) }}" class="px-6 py-5 flex flex-col gap-4">
          @csrf
          @method('PUT')

          {{-- Nama --}}
          <div>
            <label for="name" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
              Nama
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required
              class="w-full px-3.5 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
            @error('name')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Username --}}
          <div>
            <label for="username" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
              Username
            </label>
            <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->username) }}"
              required
              class="w-full px-3.5 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
            @error('username')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Email --}}
          <div>
            <label for="email" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
              Email
            </label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
              required
              class="w-full px-3.5 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
            @error('email')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Phone --}}
          <div>
            <label for="phone_number"
              class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
              Telp
            </label>
            <input type="tel" id="phone_number" name="phone_number"
              value="{{ old('phone_number', auth()->user()->phone_number) }}" placeholder="08xxxxxxxxxx"
              class="w-full px-3.5 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
            @error('phone_number')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex items-center justify-end gap-3">
            <button type="submit" id="btnEditProfile"
              class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 flex items-center gap-2 cursor-pointer">
              <span class="btnLoading hidden w-5 h-5 stroke-white">
                <svg viewBox="0 0 50 50">
                  <circle cx="25" cy="25" r="20" fill="none" stroke="" stroke-width="3"
                    stroke-linecap="round" stroke-dasharray="60 120">
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25"
                      dur="1s" repeatCount="indefinite"></animateTransform>
                  </circle>
                </svg>
              </span>
              Update Profile
            </button>
          </div>
        </form>
      </div>

      {{-- password --}}
      <div class="h-fit border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
          <div
            class="w-12 h-12 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-800">Ubah Password</p>
            <p class="text-xs text-gray-400 mt-0.5">Pastikan password baru kuat</p>
          </div>
        </div>

        <form method="POST" action="{{ route('updatePassword', $user->id_user) }}"
          class="px-6 py-5 flex flex-col gap-4">
          @csrf
          @method('PUT')

          {{-- Password baru --}}
          <div>
            <label for="password" class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
              Password Baru
            </label>
            <div class="relative">
              <input type="password" id="new_password" name="new_password" required placeholder="●●●●●●●●"
                class="input input-password w-full px-3.5 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
              <button type="button" data-toggle="password"
                class="show-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg class="w-4 h-4 eye-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
              </button>
            </div>
            @error('password')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Konfirmasi password --}}
          <div>
            <label for="confirm_password"
              class="block mb-1.5 text-xs font-semibold text-gray-400 uppercase tracking-widest">
              Konfirmasi Password Baru
            </label>
            <div class="relative">
              <input type="password" id="confirm_password" name="confirm_password" required placeholder="●●●●●●●●"
                class="input input-password w-full px-3.5 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
              <button type="button" data-toggle="confirm_password"
                class="show-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg class="w-4 h-4 eye-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
              </button>
            </div>
          </div>

          <div class="flex items-center justify-end">
            <button type="submit" id="btnEditPassword"
              class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 flex items-center gap-2 cursor-pointer">
              <span class="btnLoading hidden w-5 h-5 stroke-white">
                <svg viewBox="0 0 50 50">
                  <circle cx="25" cy="25" r="20" fill="none" stroke="" stroke-width="3"
                    stroke-linecap="round" stroke-dasharray="60 120">
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25"
                      dur="1s" repeatCount="indefinite"></animateTransform>
                  </circle>
                </svg>
              </span>
              Perbarui Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).on('click', '.show-password', function() {
      let input = $(this).closest('.relative').find('.input-password');
      let eyeOpen = $(this).find('.eye-open');
      let eyeClosed = $(this).find('.eye-close');

      if (input.attr('type') == 'password') {
        input.attr('type', 'text');
        eyeOpen.addClass('hidden');
        eyeClosed.removeClass('hidden');
      } else {
        input.attr('type', 'password');
        eyeOpen.removeClass('hidden');
        eyeClosed.addClass('hidden');
      }
    });

    $(document).on('click', '#btnEditProfile', function(event) {
      event.preventDefault();
      const form = $(this).closest('form');
      Swal.fire({
        title: "Yakin Edit Profile?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#4E38F6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            beforeSend: function() {
              $('#btnEditProfile').prop('disabled', true).addClass('btn-disabled cursor-not-allowed');
              $('#btnEditProfile .btnLoading').prop('disabled', false).removeClass('hidden');
            },
            success: function(response) {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Success update profile",
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
              })
            },
            error: function(xhr) {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: "Terjadi error update profile",
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
              })
            },
            complete: function() {
              $('#btnEditProfile').prop('disabled', false).removeClass(
                'btn-disabled cursor-not-allowed');
              $('#btnEditProfile .btnLoading').prop('disabled', false).addClass('hidden');
              unblockButtons();
            }
          })
        }
      })
    });

    $(document).on('click', '#btnEditPassword', function(event) {
      const form = $(this).closest('form');
      let new_password = $('#new_password');
      let confirm_password = $('#confirm_password');
      if (!new_password.val()) {
        Swal.fire({
          title: "Password baru tidak boleh kosong",
          icon: "warning",
          confirmButtonColor: "#4E38F6",
        });
        return false;
      } else if (new_password.val() !== confirm_password.val()) {
        Swal.fire({
          title: "Password baru harus sama dengan konfirmasi password",
          icon: "info",
          confirmButtonColor: "#4E38F6",
        });
        return false;
      } else {
        if (new_password.val().length < 8 || confirm_password.val().length < 8) {
          Swal.fire({
            title: "Panjang password harus lebih dari 8 karakter",
            icon: "info",
            confirmButtonColor: "#4E38F6",
          });
          return false;
        } else {
          event.preventDefault();
          Swal.fire({
            title: "Yakin Update Password?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#4E38F6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Update"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                  $('#btnEditPassword').prop('disabled', true).addClass('btn-disabled cursor-not-allowed');
                  $('#btnEditPassword .btnLoading').prop('disabled', false).removeClass('hidden');
                },
                success: function(resp) {
                  Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: "Success update password",
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                  })
                  new_password.val("");
                  confirm_password.val("");
                },
                error: function(xhr) {
                  Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Terjadi error update password",
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                  })
                  new_password.val("");
                  confirm_password.val("");
                },
                complete: function() {
                  $('#btnEditPassword').prop('disabled', false).removeClass(
                    'btn-disabled cursor-not-allowed');
                  $('#btnEditPassword .btnLoading').prop('disabled', false).addClass('hidden');
                  unblockButtons();
                }
              })
            }
          })
        }
      }
    })
  </script>
</x-app-layout>
