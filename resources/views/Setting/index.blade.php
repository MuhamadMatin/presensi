<x-app-layout>
  <table class="table table-bordered" id="list_table">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Logo</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

  <script>
    var list_table = $('#list_table').DataTable({
      processing: true,
      serverSide: true,
      scrollX: true,
      searching: false,
      ordering: false,
      paging: false,
      // language: {
      // loading
      //   loadingRecords: '&nbsp;',
      //   processing: function() {
      //     var loader = $('#providers-table_processing');
      //     var width = $('.card-table').width();
      //     loader.width(width);
      //     return loadingMessage;
      //   },
      // },
      ajax: {
        url: '{{ route('settings.datatable') }}',
        type: 'GET',
      },
      columns: [{
          data: 'name',
          name: 'name',
        },
        {
          data: 'logo',
          name: 'logo',
          render: function(data) {
            return `
              <div id="foto-preview" class="flex gap-2 mt-2.5 flex-wrap">
                <img src="{{ Storage::url('favicon.ico') }}" alt="icon" class="w-20 h-20 object-cover rounded-lg border border-gray-200"/>
              </div>
            `;
          }
        },
        {
          data: 'id_setting',
          name: 'action',
          render: function(data) {
            var editUrl = '{{ route('settings.edit', ':id') }}'.replace(':id', data);
            return `
              <span class="flex gap-2">
                  <a class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 flex items-center gap-2 cursor-pointer" href="${editUrl}">Edit</a>
              </span>
            `;
          }
        },
      ]
    });
  </script>
</x-app-layout>
