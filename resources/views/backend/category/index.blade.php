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
      <h5 class="card-title m-0"> <i class="fa fa-cog"></i> &ensp; Data Kategori</h5>
      <div class="card-tools">
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
        <table class="table table-bordered table-hover table-striped" id="category-table">

        </table>
      </div>
    </div>
  </div>
</div>


<form action="#" method="post" id="add-form">
  <div class="modal fade" id="create-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Tambah Data Kategori</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="">Nama Kategori : <span class="text-danger">*</span></label>
              <input type="text" name="name" id="add-name" class="form-control" placeholder="Masukan Nama Kategori..." required>
              <span class="text-danger" id="add-name-error"></span>
            </div>
            <div class="form-group">
              <label for="">Detail Kategori :</label>
              <textarea name="detail" id="add-detail" class="form-control" placeholder="Masukan Detail Kategori..."></textarea>
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
          <h4 class="modal-title">Form Edit Data Kategori</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="edit-id" required>
            <div class="form-group">
              <label for="">Nama Kategori : <span class="text-danger">*</span></label>
              <input type="text" name="name" id="edit-name" class="form-control" placeholder="Masukan Nama Kategori..." required>
              <span class="text-danger" id="edit-name-error"></span>
            </div>
            <div class="form-group">
              <label for="">Detail Kategori :</label>
              <textarea name="detail" id="edit-detail" class="form-control" placeholder="Masukan Detail Kategori..."></textarea>
              <span class="text-danger" id="edit-detail-error"></span>
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
        url: "{{ route('Category.store') }}",
        method: 'POST',
        data: {
          _token:"{{ csrf_token() }}",
          name: name,
          detail: detail
        },
        success: function(res) {
          $('#create-modal').modal('hide');
          $('#category-table').DataTable().ajax.reload();
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

    $('#category-table').on('click', '#data-delete', function() {
      var id = $(this).data('id');
      $.ajax({
        url: "Category/"+id,
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          _method: "DELETE",
          id: id,
        },
        success: function(res) {
          $('#category-table').DataTable().ajax.reload();
          if (res.status == '200') {
            toastWarning(res.success);
          }
          console.log(res);
        },
        error: function(e) {
          toastError('Terjadi Kesalahan !');
          console.log(e);
        }
      })
    });

    $('#category-table').on('click', '#data-edit', function() {
      var id = $(this).data('id');
      $.ajax({
        url: "Category/"+id+"/edit",
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
        url: "Category/"+id,
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
          $('#category-table').DataTable().ajax.reload();
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
  });
</script>
@endsection