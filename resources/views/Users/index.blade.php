<x-app-layout>
  <div class="flex items-center gap-3">
    <a href="{{ route('users.create') }}"
      class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150">
      Tambah User
    </a>
  </div>

  <table class="table table-bordered" id="list_table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Email</th>
        <th>Telp</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

  <script>
    var list_table = $('#list_table').DataTable({
      initComplete: function() {
        var $select = $('<select id="filterRole">' +
          '<option value="">Semua Role</option>'
          @foreach ($roles as $role)
            +'<option value="{{ $role->id_role }}">{{ $role->name }}</option>'
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
        url: '{{ route('users.datatable') }}',
        type: 'GET',
        data: function(d) {
          d.search = $('input[type="search"]').val();
          d.role = $('#filterRole').val();
        }
      },
      searchDelay: 500,
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'username',
          name: 'username'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'phone_number',
          name: 'phone_number'
        },
        {
          data: 'role',
          name: 'role',
          orderable: false,
          searchable: false,
          orderable: false,
          searchable: false,
          render: function(data) {
            console.log(data);
            return `
            <p
              class="px-2.5 py-1 rounded-full text-xs font-semibold
              ${ data === 'Freelance' ? 'bg-green-50 text-green-600' : '' }
              ${ data === 'Karyawan Tetap' ? 'bg-blue-50 text-blue-600' : '' }
                  ${ data === "Intership" ? 'bg-yellow-50 text-yellow-600' : '' }
                  ${ data === 'Admin' ? 'bg-red-50 text-red-600' : '' }">
              ${ data ?? '-' }
            </p>
            `;
          }
        },
        {
          data: 'id_user',
          name: 'action',
          orderable: false,
          searchable: false,
          render: function(data) {
            var editUrl = '{{ route('users.edit', ':id') }}'.replace(':id', data);
            var deleteUrl = '{{ route('users.destroy', ':id') }}'.replace(':id', data);
            var resetPasswordUrl = '{{ route('resetPassword', ':id') }}'.replace(':id', data);
            return `
              <span class="flex gap-2">
                  <a class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition duration-150 flex items-center gap-2 cursor-pointer" href="${editUrl}">Edit</a>
                  <form method="POST" action="${deleteUrl}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-delete px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500/40 transition duration-150 flex items-center gap-2 cursor-pointer">Delete</button>
                  </form>
                  <form method="POST" action="${resetPasswordUrl}">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn-reset-password px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500/40 transition duration-150 flex items-center gap-2 cursor-pointer">Reset</button>
                  </form>
              </span>
            `;
          }
        },
      ]
    });

    $(document).on('change', '#filterRole', function() {
      list_table.draw();
    });

    $(document).on('click', '.btn-delete', function(event) {
      event.preventDefault();
      var form = $(this).closest("form");
      Swal.fire({
        title: "Yakin Delete User?",
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
                title: "Success delete user",
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

    $(document).on('click', '.btn-reset-password', function(event) {
      event.preventDefault();
      var form = $(this).closest("form");
      Swal.fire({
        title: "Yakin Reset Password User?",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: "#4E38F6",
        confirmButtonColor: "#F54900",
        confirmButtonText: "Reset"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: {
              _token: form.find('input[name="_token"]').val(),
              _method: 'PATCH'
            },
            beforeSend: function() {
              $('.btn').addClass("btn-disabled");
            },
            success: function(resp) {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: resp.message,
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
                title: "Terjadi error reset password",
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
