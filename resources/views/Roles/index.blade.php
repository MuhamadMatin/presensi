<x-app-layout>
  <div class="flex items-center gap-3">
    <a href="{{ route('roles.create') }}"
      class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150">
      Tambah Role
    </a>
  </div>

  <table class="table table-bordered" id="list_table">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

  <script>
    var list_table = $('#list_table').DataTable({
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
        url: '{{ route('roles.datatable') }}',
        type: 'GET',
        data: function(d) {
          d.search = $('input[type="search"]').val();
        }
      },
      searchDelay: 500,
      columns: [{
          data: 'name',
          name: 'name'
        },
        {
          data: 'description',
          name: 'description'
        },
        {
          data: 'id_role',
          name: 'action',
          orderable: false,
          searchable: false,
          render: function(data) {
            var editUrl = '{{ route('roles.edit', ':id') }}'.replace(':id', data);
            var deleteUrl = '{{ route('roles.destroy', ':id') }}'.replace(':id', data);
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

    $(document).on('click', '.btn-delete', function(event) {
      event.preventDefault();
      var form = $(this).closest("form");
      Swal.fire({
        title: "Yakin Delete Role?",
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
                title: "Success delete role",
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
