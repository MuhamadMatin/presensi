<x-app-layout>
  <div class="flex items-center gap-3">
    <a href="{{ route('presences.create') }}"
      class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150">
      Tambah Presensi
    </a>
  </div>

  <table class="table table-bordered" id="list_table">
    <thead class="text-center">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Status</th>
        <th>Masuk</th>
        <th>Pulang</th>
        <th>Lokasi</th>
        <th>Deskripsi</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

  <script>
    var list_table = $('#list_table').DataTable({
      initComplete: function() {
        var $select = $('<select id="filterStatus">' +
          '<option value="">Semua Status</option>'
          @foreach ($statuses as $status)
            +'<option value="{{ $status->id_status }}">{{ $status->name }}</option>'
          @endforeach +
          '</select>'
        ).addClass(
          'px-3 py-1.5 text-sm text-gray-800 bg-white border border-gray-400 rounded-lg ' +
          'focus:outline-none focus:border-indigo-500 cursor-pointer transition duration-150 ml-2'
        );

        $('.dt-layout-start:first').append($select);
      },
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      processing: true,
      serverSide: true,
      scrollX: true,
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
        url: '{{ route('presences.datatable') }}',
        type: 'GET',
        data: function(d) {
          d.search = $('input[type="search"]').val();
          d.status = $('#filterStatus').val();
        }
      },
      searchDelay: 500,
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
        },
        {
          data: 'user_name',
          name: 'user_name'
        },
        {
          data: 'status',
          name: 'status',
          orderable: false,
          searchable: false,
          render: function(data) {
            console.log(data);
            return `
            <span
              class="px-2.5 py-1 rounded-full text-xs font-semibold
              ${ data === 'Hadir' ? 'bg-green-50 text-green-600' : '' }
                  ${ ["Izin", "Sakit"].includes(data) ? 'bg-yellow-50 text-yellow-600' : '' }
                  ${ data === 'Cuti' ? 'bg-blue-50 text-blue-600' : '' }">
              ${ data ?? '-' }
            </span>
            `;
          }
        },
        {
          data: 'entry',
          name: 'entry'
        },
        {
          data: 'out',
          name: 'out'
        },
        {
          data: 'location',
          name: 'location',
          orderable: false,
        },
        {
          data: 'description',
          name: 'description',
          orderable: false,
          searchable: false,
        },
        {
          data: 'id_presence',
          name: 'action',
          orderable: false,
          searchable: false,
          render: function(data) {
            var editUrl = '{{ route('presences.edit', ':id') }}'.replace(':id', data);
            var deleteUrl = '{{ route('presences.destroy', ':id') }}'.replace(':id', data);
            return `
              <span class="flex gap-2">
                  <a class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 flex items-center gap-2 cursor-pointer" href="${editUrl}">Edit</a>
                  <form method="POST" action="${deleteUrl}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-delete px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500/40 transition duration-150 flex items-center gap-2 cursor-pointer">Delete</button>
                  </form>
              </span>
            `;
          }
        },
      ]
    });

    $(document).on('change', '#filterStatus', function() {
      list_table.draw();
    });

    $(document).on('click', '.btn-delete', function(event) {
      event.preventDefault();
      var form = $(this).closest("form");
      Swal.fire({
        title: "Yakin Delete Presensi?",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: "#4E38F6",
        confirmButtonColor: "#d33",
        confirmButtonText: "Delete"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: {
              _token: form.find('input[name="_token"]').val(),
              _method: 'DELETE'
            },
            beforeSend: function() {
              $('.btn').addClass("btn-disabled");
            },
            success: function(response) {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Success delete presensi",
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
              })
              list_table.ajax.reload();
            },
            error: function(xhr) {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: "Terjadi error menghapus data",
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
              })
            },
            complete: function() {
              $('.btn').removeClass("btn-disabled");
            }
          })
        }
      })
    });
  </script>
</x-app-layout>
