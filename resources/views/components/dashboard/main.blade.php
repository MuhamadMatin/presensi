<div class="flex flex-col h-full bg-gray-50">
  {{-- topbar --}}
  <x-dashboard.header />

  <div class="flex flex-1 overflow-hidden pt-14">
    {{-- sidebar --}}
    <x-dashboard.sidebar />

    {{-- overlay mobile --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-30 hidden md:hidden"></div>

    {{-- main --}}
    <div class="flex-1 min-w-0 overflow-y-auto">
      <div class="p-3">
        {{ $slot }}
      </div>
    </div>
  </div>

  <script>
    const sidebar = $('#sidebar');
    const overlay = $('#sidebarOverlay');
    const btnToggle = $('#sidebarToggle');
    const iconOpen = $('#iconOpen');
    const iconClose = $('#iconClose');

    $(function() {
      let isOpen = false;

      function openSidebar() {
        sidebar.removeClass('-translate-x-full');
        overlay.removeClass('hidden');
        iconOpen.addClass('hidden');
        iconClose.removeClass('hidden');
        $('body').addClass('overflow-hidden');
        isOpen = true;
      }

      function closeSidebar() {
        sidebar.addClass('-translate-x-full');
        overlay.addClass('hidden');
        iconOpen.removeClass('hidden');
        iconClose.addClass('hidden');
        $('body').removeClass('overflow-hidden');
        isOpen = false;
      }

      btnToggle.on('click', function() {
        isOpen ? closeSidebar() : openSidebar();
      });

      overlay.on('click', closeSidebar);
    });
  </script>
</div>
