@extends('backend.layouts.master')

@section('css')
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <style>
    .select2-container .select2-selection--single {
      height: 37.99px !important;
    }

    .text-sm .select2-container--default .select2-selection--single .select2-selection__rendered, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__rendered {
      margin-top: -3px !important;
    }

    .select2-selection__rendered {
      font-size: 16px !important;
      color: #818181 !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single {
      border-color: #ced4da !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px !important;
      top: 1px !important; 
    }
  </style>
@endsection

@section('content')
<div class="col-12">
  <div class="card card-warning card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><i class="fa fa-edit"></i> &ensp; Form Edit Data Barang</h5>
      <div class="card-tools">
        <button class="btn btn-tool" data-card-widget="collapse">
          <i class="fa fa-minus"></i>
        </button>
        <a href="{{ route('Stuff.index') }}" class="btn btn-tool">
          <i class="fas fa-times"></i> &ensp; Kembali
        </a>
      </div>
    </div>
    <div class="card-body">
      <form action="{{ route('Stuff.update', $stuff->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="form-group col-md-6 col-lg-6">
            <label for="">Nama Barang : <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Masukan Nama Barang..." value="{{ $stuff->name }}" required autofocus>
            <span class="text-danger">
              {{ $errors->first('name') }}
            </span>
          </div>
          <div class="form-group col-md-3 col-lg-3 {{ $errors->has('category_id') ? 'is-invalid':'' }}">
            <label for="">Kategori Barang : <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;" data-placeholder="Pilih Kategori Barang" required>
              <option value=""></option>
              @foreach ($category as $item)
                <option value="{{ $item->id }}" {{ $item->id == $stuff->category_id ? 'selected':'' }}>{{ $item->name }}</option>
              @endforeach
              <span class="text-danger">
                {{ $errors->first('category_id') }}
              </span>
            </select>
          </div>
          <div class="form-group col-md-3 col-lg-3  {{ $errors->has('storage_id') ? 'is-invalid':'' }}">
            <label for="">Gudang Penyimpanan : <span class="text-danger">*</span></label>
            <select name="storage_id" id="storage_id" class="form-control select2" style="width: 100%;" data-placeholder="Pilih Lokasi Gudang" required>
              <option value=""></option>
              @foreach ($storage as $item)
                <option value="{{ $item->id }}" {{ $item->id == $stuff->storage_id ? 'selected':'' }}>{{ $item->name }}</option>
              @endforeach
            </select>
            <span class="text-danger">
              {{ $errors->first('storage_id') }}
            </span>
          </div>
          <div class="form-group col-12">
            <label for="">Deskripsi Barang : <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}" placeholder="Masukan Deskripsi Barang..." required>{{ $stuff->description }}</textarea>
          </div>  
          <div class="form-group col-12">
            <hr class="mt-0 mb-2">
            <div class="row">
              <div class="col-md-2 col-lg-2">
                <button type="submit" class="btn btn-outline-info btn-block mt-1">
                  <i class="fa fa-plus"></i> &ensp;
                  Edit Data
                </button>
              </div>
              <div class="col-md-2 col-lg-2">
                <button type="submit" class="btn btn-outline-danger btn-block mt-1">
                  <i class="fa fa-undo"></i> &ensp;
                  Reset Ulang
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<form action="#" method="post" id="category-add-form">
  <div class="modal fade" id="category-create-modal">
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
            <input type="text" name="name" id="category-add-name" class="form-control" placeholder="Masukan Nama Kategori..." required>
            <span class="text-danger" id="category-add-name-error"></span>
          </div>
          <div class="form-group">
            <label for="">Detail Kategori :</label>
            <textarea name="detail" id="category-add-detail" class="form-control" placeholder="Masukan Detail Kategori..."></textarea>
            <span class="text-danger" id="category-add-detail-error"></span>
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


<form action="#" method="post" id="storage-add-form">
  <div class="modal fade" id="storage-create-modal">
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
              <input type="text" name="name" id="storage-add-name" class="form-control" placeholder="Masukan Nama Gudang..." required>
              <span class="text-danger" id="storage-add-name-error"></span>
            </div>
            <div class="form-group">
              <label for="">Detail Gudang :</label>
              <textarea name="detail" id="storage-add-detail" class="form-control" placeholder="Masukan Detail Gudang..."></textarea>
              <span class="text-danger" id="storage-add-detail-error"></span>
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
  <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {      
      $('#category_id').select2().on('select2:open', () => {
        $(".select2-results:not(:has(button))").append(`
        <button class="btn btn-outline-secondary btn-block flat" data-toggle="modal" data-target="#category-create-modal" onclick="$('#category_id').select2('close'); $('#storage_id').select2('close');" style="border-bottom-left-radius: 1px !important; border-bottom-right-radius: 1px !important;">
          <i class="fa fa-plus"></i> &ensp; Buat Data Baru
        </button>
        `
        );
      });

      $('#storage_id').select2().on('select2:open', () => {
        $(".select2-results:not(:has(button))").append(`
        <button class="btn btn-outline-secondary btn-block flat" data-toggle="modal" data-target="#storage-create-modal" onclick="$('#category_id').select2('close'); $('#storage_id').select2('close');" style="border-bottom-left-radius: 1px !important; border-bottom-right-radius: 1px !important;">
          <i class="fa fa-plus"></i> &ensp; Buat Data Baru
        </button>
        `
        );
      });

      function getCategory() {
        $.ajax({
          url: "{{ route('json.category') }}",
          method: "GET",
          success: function (res) {
            $('#category_id').empty();
            $('#category_id').append('<option value=""></option>')
            res.forEach(data => {
              $('#category_id').append('<option value="'+data.id+'">'+data.name+'</option>')
            });
          },
          error: function (e) {
            toastWarning('Silahkan Refresh Ulang Halaman !');
          }
        })
      }

      function getStorage() {
        $.ajax({
          url: "{{ route('json.storage') }}",
          method: "GET",
          success: function (res) {
            $('#storage_id').empty();
            $('#storage_id').append('<option value=""></option>')
            res.forEach(data => {
              $('#storage_id').append('<option value="'+data.id+'">'+data.name+'</option>')
            });
          },
          error: function (e) {
            toastWarning('Silahkan Refresh Ulang Halaman !');
          }
        })
      }

      $('#storage-add-form').on('submit', function(e) {
        e.preventDefault(0);
        var name = $('#storage-add-name').val();
        var detail = $('#storage-add-detail').val();
        
        $.ajax({
          url: "{{ route('Storage.store') }}",
          method: 'POST',
          data: {
            _token:"{{ csrf_token() }}",
            name: name,
            detail: detail
          },
          success: function(res) {
            $('#storage-create-modal').modal('hide');
            if (res.status == '200') {
              getStorage();
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

      $('#category-add-form').on('submit', function(e) {
        e.preventDefault(0);
        var name = $('#category-add-name').val();
        var detail = $('#category-add-detail').val();
        
        $.ajax({
          url: "{{ route('Category.store') }}",
          method: 'POST',
          data: {
            _token:"{{ csrf_token() }}",
            name: name,
            detail: detail
          },
          success: function(res) {
            $('#category-create-modal').modal('hide');
            if (res.status == '200') {
              getCategory();
              toastSuccess(res.message);
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

      $('#category-create-modal').on('hidden.bs.modal', function () {
        $('#category-add-name').val('').removeClass('is-invalid');
        $('#category-add-detail').val('').removeClass('is-invalid');
        $('#category-add-name-error').text('');
        $('#category-add-detail-error').text('');
      });

      $('#storage-create-modal').on('hidden.bs.modal', function () {
        $('#storage-add-name').val('').removeClass('is-invalid');
        $('#storage-add-detail').val('').removeClass('is-invalid');
        $('#storage-add-name-error').text('');
        $('#storage-add-detail-error').text('');
      });

    });
  </script>
@endsection