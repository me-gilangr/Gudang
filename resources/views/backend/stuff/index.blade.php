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
      <h5 class="card-title m-0"> <i class="fa fa-boxes"></i> &ensp; Data Barang</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" id="trashed">
          <i class="fa fa-trash"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button> 
        <a href="{{ route('Stuff.create') }}" class="btn btn-tool">
          <i class="fas fa-plus"></i> &ensp; Tambah Data
        </a>
      </div> 
    </div>
    <div class="card-body"> 
      <div class="table-responsive"> 
        <table class="table table-bordered table-hover table-striped" id="stuff-table">

        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="trashed-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tempat Sampah Data Barang</h4>
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
                <th>Nama</th>
                <th>Kategori</th>
                <th>Lokasi Barang</th>
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
      ajax: "{{ route('json.trashed.stuff') }}",
      columnDefs: [
        {className: "text-center", "targets": [4]},
        {className: "text-center", "targets": [5]},
      ],
      columns: [
        {data: 'id', searchable: false},
        {data: 'name', searchable: true},
        {data: 'kategori', searchable: true},
        {data: 'gudang', searchable:true},
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
        url: "{{ route('Stuff.restore') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          restore_id:id,
        },
        success: function (res) {
          $('#stuff-table').DataTable().ajax.reload();
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
          url: "{{ route('Stuff.permanent') }}",
          method: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            permanent_id:id,
          },
          success: function (res) {
            $('#stuff-table').DataTable().ajax.reload();
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