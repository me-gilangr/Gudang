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
      <h5 class="card-title m-0"> <i class="fa fa-archive"></i> &ensp; Data Gudang</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" id="trashed">
          <i class="fa fa-trash"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button> 
        <button class="btn btn-tool" id="add-data">
          <i class="fas fa-plus"></i> &ensp; Tambah Data
        </button>
      </div> 
    </div>
    <div class="card-body"> 
      <div class="table-responsive"> 
        <table class="table table-bordered table-hover table-striped" id="storage-table">

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="trashed-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tempat Sampah Data Gudang</h4>
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
                <th>Detail</th>
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

<form action="#" method="post" id="add-form">
  <div class="modal fade" id="create-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Tambah Data Gudang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="">Nama Gudang : <span class="text-danger">*</span></label>
              <input type="text" name="name" id="add-name" class="form-control" placeholder="Masukan Nama Gudang..." required>
              <span class="text-danger" id="add-name-error"></span>
            </div>
            <div class="form-group">
              <label for="">Detail Gudang :</label>
              <textarea name="detail" id="add-detail" class="form-control" placeholder="Masukan Detail Gudang..."></textarea>
              <span class="text-danger" id="add-detail-error"></span>
            </div> 
        </div>
        <div class="modal-footer justify-content-between">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-success">Tambah Data</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form action="#" method="post" id="edit-form">
  <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Edit Data Gudang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="edit-id" required>
            <div class="form-group">
              <label for="">Nama Gudang : <span class="text-danger">*</span></label>
              <input type="text" name="name" id="edit-name" class="form-control" placeholder="Masukan Nama Gudang..." required>
              <span class="text-danger" id="edit-name-error"></span>
            </div>
            <div class="form-group">
              <label for="">Detail Gudang :</label>
              <textarea name="detail" id="edit-detail" class="form-control" placeholder="Masukan Detail Gudang..."></textarea>
              <span class="text-danger" id="edit-detail-error"></span>
            </div> 
        </div>
        <div class="modal-footer justify-content-between">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('script')
{{ $dataTable->scripts() }}
<script>
  $(document).ready(function() {  
    $('#add-data').on('click', function() {
      $('#create-modal').modal('show');
      $('#name').focus();
    });

    $('#add-form').on('submit', function(e) {
      e.preventDefault(0);
      var name = $('#add-name').val();
      var detail = $('#add-detail').val();
      
      $.ajax({
        url: "{{ route('Storage.store') }}",
        method: 'POST',
        data: {
          _token:"{{ csrf_token() }}",
          name: name,
          detail: detail
        },
        success: function(res) {
          $('#create-modal').modal('hide');
          $('#storage-table').DataTable().ajax.reload();
          if (res.status == '200') {
            toastSuccess('Data Berhasil di-Tambahkan !');
          }
        },
        error: function(e) {
          if (e.status == '422') {
            var errors = $.parseJSON(e.responseText);
            $.each(errors, function (key, value) {
            $('#response').addClass("alert alert-danger");
              if($.isPlainObject(value)) {
                $.each(value, function (key, value) {                       
                  $('#'+key).addClass('is-invalid');
                  $('#add-' + key + '-error').text(value);
                });
              }
            });
          } else {
            toastError('Terjadi Kesalahan !');
          }
        } 
      });
    });

    $('#storage-table').on('click', '#data-delete', function() {
      var id = $(this).data('id');
      $.ajax({
        url: "Storage/"+id,
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          _method: "DELETE",
          id: id,
        },
        success: function(res) {
          $('#storage-table').DataTable().ajax.reload();
          $('#trashed-table').DataTable().ajax.reload();
          if (res.status == '200') {
            toastWarning(res.success);
          }
        },
        error: function(e) {
          toastError('Terjadi Kesalahan !');
        }
      })
    });

    $('#storage-table').on('click', '#data-edit', function() {
      var id = $(this).data('id');
      $.ajax({
        url: "Storage/"+id+"/edit",
        method: "GET",
        success: function(res) {
          $('#edit-modal').modal('show');
          $('#edit-id').val(res.id);
          $('#edit-name').val(res.name);
          $('#edit-detail').val(res.detail);
        },
        error: function(e) {
          if (e.status == '400') {
            toastError('Terjadi Kesalahan !');
          }
        }
      });
    });
    
    $('#edit-form').on('submit', function(e) {
      e.preventDefault(0);
      var id = $('#edit-id').val();
      var name = $('#edit-name').val();
      var detail = $('#edit-detail').val();
      
      $.ajax({
        url: "Storage/"+id,
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          _method: "PUT",
          id: id,
          name: name,
          detail: detail
        },
        success: function(res) {
          $('#edit-modal').modal('hide');
          $('#storage-table').DataTable().ajax.reload();
          if (res.status == '200') {
            toastInfo(res.success);
          }
        },
        error: function(e) {
          if (e.status == '422') {
            var errors = $.parseJSON(e.responseText);
            $.each(errors, function (key, value) {
            $('#response').addClass("alert alert-danger");
              if($.isPlainObject(value)) {
                $.each(value, function (key, value) {                       
                  $('#'+key).addClass('is-invalid');
                  $('#add-' + key + '-error').text(value);
                });
              }
            });
          } else {
            toastError('Terjadi Kesalahan !');
          }
        }
      });
    });

    $('#create-modal').on('hidden.bs.modal', function () {
      $('#add-name').val('').removeClass('is-invalid');
      $('#add-detail').val('').removeClass('is-invalid');
      $('#add-name-error').text('');
      $('#add-detail-error').text('');
    });

    $('#edit-modal').on('hidden.bs.modal', function () {
      $('#edit-id').val('');
      $('#edit-name').val('').removeClass('is-invalid');
      $('#edit-detail').val('').removeClass('is-invalid');
      $('#edit-name-error').text('');
      $('#edit-detail-error').text('');
    });
    
    $('#trashed-table').DataTable({
      ordering: false,
      processing: true,
      serverSide: true,
      ajax: "{{ route('json.trashed.storage') }}",
      columnDefs: [
        {className: "text-center", "targets": [3]},
        {className: "text-center", "targets": [4]},
      ],
      columns: [
        {data: 'id', searchable: false},
        {data: 'name', searchable: true},
        {data: 'detail', searchable: true},
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
        url: "{{ route('Storage.restore') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          restore_id:id,
        },
        success: function (res) {
          $('#storage-table').DataTable().ajax.reload();
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
          url: "{{ route('Storage.permanent') }}",
          method: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            permanent_id:id,
          },
          success: function (res) {
            $('#storage-table').DataTable().ajax.reload();
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