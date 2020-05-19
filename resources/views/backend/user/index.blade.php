@extends('backend.layouts.master')

@section('content')
<style>
  .divide {
    border-right: 1px dashed #333;
  }

  table {
    width: 100% !important;
  }
</style>

<div class="col-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"> <i class="fa fa-users"></i> &ensp; Data User</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" id="trashed">
          <i class="fa fa-trash"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button> 
        <a href="{{ route('User.create') }}" class="btn btn-tool">
          <i class="fas fa-plus"></i> &ensp; Tambah Data
        </a>
      </div> 
    </div>
    <div class="card-body"> 
      <div class="table-responsive"> 
        <table class="table table-bordered table-hover table-striped" id="users-table">

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="trashed-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tempat Sampah Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped" id="trashed-table" style="width: 100%;">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Level</th>
                <th>Tanggal Hapus</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="reset" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
{{ $dataTable->scripts() }}
<script>
  $(document).ready(function() {
    $('#trashed-table').DataTable({
      ordering: false,
      processing: true,
      serverSide: true,
      ajax: "{{ route('json.trashed.user') }}",
      columnDefs: [
        {className: "text-center", "targets": [3]},
        {className: "text-center", "targets": [4]},
      ],
      columns: [
        {data: 'id', searchable: false},
        {data: 'name', searchable: true},
        {data: 'gender', searchable: true},
        {data: 'level', searchable:true},
        {data: 'deleted_at', searchable: true},
        {data: 'action', searchable: false, orderable: false}
      ]
    });

    $('#trashed').on('click', function() {
      $('#trashed-modal').modal('show');
    });
    
    $('#trashed-table').on('click', '#data-restore', function() {
      var id = $(this).data('id');
      $.ajax({
        url: "{{ route('User.restore') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          restore_id:id,
        },
        success: function (res) {
          $('#users-table').DataTable().ajax.reload();
          $('#trashed-table').DataTable().ajax.reload();
          toastSuccess(res.message);
        },
        error: function (e) {
          toastError('Terjadi Kesalahan, Silahkan Refresh Ulang Halaman !');
        }
      })
    });

    $('#trashed-table').on('click', '#data-permanent', function() {
      var con = confirm('Peringatan !! \nData Akan Di-Hapus Secara Permanen ! \nDan Tidak Dapat Di-Pulihkan. \nLakukan Penghapusan Data ?');
      if (con == true) {
        var id = $(this).data('id');
        $.ajax({
          url: "{{ route('User.permanent') }}",
          method: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            permanent_id:id,
          },
          success: function (res) {
            $('#users-table').DataTable().ajax.reload();
            $('#trashed-table').DataTable().ajax.reload();
            toastWarning(res.message);
          },
          error: function (e) {
            toastError('Terjadi Kesalahan, Silahkan Refresh Ulang Halaman !');
          }
        })
      }
    });
  });
</script>
@endsection