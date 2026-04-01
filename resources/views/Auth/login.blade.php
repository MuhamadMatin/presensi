<x-guest-layout>
  <main class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-md">
      {{-- Card --}}
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">
        {{-- Logo --}}
        <div class="flex items-center justify-center gap-3 mb-8">
          <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center">
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
          <p class="text-lg font-semibold text-gray-800 tracking-wide">{{ session('name') }}</p>
        </div>

        <form action="{{ route('store.login') }}" method="POST" id="form" class="flex flex-col gap-5">
          @csrf

          {{-- username --}}
          <div>
            <label for="username" class="block mb-1.5 text-sm font-medium text-gray-700">Username</label>
            <div class="relative flex items-center">
              <span class="absolute left-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                  <path
                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                </svg>
              </span>
              <input id="username" type="text" name="username" placeholder="Username" required
                value="{{ old('username') }}"
                class="w-full pl-9 pr-4 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
            </div>
            @error('username')
              <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
              </p>
            @enderror
          </div>

          {{-- password --}}
          <div>
            <label for="password" class="block mb-1.5 text-sm font-medium text-gray-700">Password</label>
            <div class="relative flex items-center">
              <span class="absolute left-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                  <path fill-rule="evenodd"
                    d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                    clip-rule="evenodd" />
                </svg>
              </span>
              <input id="password" type="password" name="password" placeholder="●●●●●●●●" required
                class="w-full pl-9 pr-10 py-2.5 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg placeholder-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition duration-150" />
              {{-- toggle eye --}}
              <label for="showPassword"
                class="absolute right-3 cursor-pointer text-gray-400 hover:text-gray-600 transition-colors">
                <input type="checkbox" id="showPassword" class="hidden">
                <svg viewBox="0 0 28 28" id="eyeOpen" class="w-4 h-4" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path clip-rule="evenodd"
                    d="M17.7469 15.4149C17.9855 14.8742 18.1188 14.2724 18.1188 14.0016C18.1188 11.6544 16.2952 9.7513 14.046 9.7513C11.7969 9.7513 9.97332 11.6544 9.97332 14.0016C9.97332 16.3487 12.0097 17.8886 14.046 17.8886C15.3486 17.8886 16.508 17.2515 17.2517 16.2595C17.4466 16.0001 17.6137 15.7168 17.7469 15.4149ZM14.046 15.7635C14.5551 15.7635 15.0205 15.5684 15.3784 15.2457C15.81 14.8566 16 14.2807 16 14.0016C16 12.828 15.1716 11.8764 14.046 11.8764C12.9205 11.8764 12 12.8264 12 14C12 14.8104 12.9205 15.7635 14.046 15.7635Z"
                    fill="currentColor" fill-rule="evenodd"></path>
                  <path clip-rule="evenodd"
                    d="M1.09212 14.2724C1.07621 14.2527 1.10803 14.2931 1.09212 14.2724C0.96764 14.1021 0.970773 13.8996 1.09268 13.7273C1.10161 13.7147 1.11071 13.7016 1.11993 13.6882C4.781 8.34319 9.32105 5.5 14.0142 5.5C18.7025 5.5 23.2385 8.33554 26.8956 13.6698C26.965 13.771 27 13.875 27 13.9995C27 14.1301 26.9593 14.2399 26.8863 14.3461C23.2302 19.6702 18.6982 22.5 14.0142 22.5C9.30912 22.5 4.75717 19.6433 1.09212 14.2724ZM3.93909 13.3525C3.6381 13.7267 3.6381 14.2722 3.93908 14.6465C7.07417 18.5443 10.6042 20.3749 14.0142 20.3749C17.4243 20.3749 20.9543 18.5443 24.0894 14.6465C24.3904 14.2722 24.3904 13.7267 24.0894 13.3525C20.9543 9.45475 17.4243 7.62513 14.0142 7.62513C10.6042 7.62513 7.07417 9.45475 3.93909 13.3525Z"
                    fill="currentColor" fill-rule="evenodd"></path>
                </svg>
                <svg viewBox="0 0 28 28" id="eyeClosed" class="hidden w-4 h-4" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path clip-rule="evenodd"
                    d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z"
                    fill="currentColor" fill-rule="evenodd"></path>
                  <path
                    d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z"
                    fill="currentColor"></path>
                </svg>
              </label>
            </div>
            @error('password')
              <p class="mt-1.5 text-xs text-red-500">
                {{ $message }}
              </p>
            @enderror
          </div>

          <button type="submit" id="btnSubmit"
            class="mt-1 w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 cursor-pointer flex items-center gap-2 justify-center">
            <span class="btnLoading hidden w-5 h-5 stroke-white">
              <svg viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="" stroke-width="3"
                  stroke-linecap="round" stroke-dasharray="60 120">
                  <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25"
                    dur="1s" repeatCount="indefinite"></animateTransform>
                </circle>
              </svg>
            </span>
            Login
          </button>
        </form>
      </div>
    </div>
  </main>

  <script>
    const btnSubmit = $('#btnSubmit');
    const btnLoading = $('.btnLoading');

    $("#showPassword").change(function() {
      if ($(this).prop("checked")) {
        $("#eyeOpen").addClass("hidden");
        $("#eyeClosed").removeClass("hidden");
        $("#password").prop("type", "text");
      } else {
        $("#eyeOpen").removeClass("hidden");
        $("#eyeClosed").addClass("hidden");
        $("#password").prop("type", "password");
      }
    });

    $('#form').on('submit', function() {
      btnSubmit.prop('disabled', true).addClass('opacity-60 cursor-not-allowed');
      btnLoading.removeClass('hidden');
    });

    btnSubmit.prop('disabled', false).removeClass('opacity-100 cursor-auto');
    btnLoading.addClass('hidden');
  </script>
</x-guest-layout>
