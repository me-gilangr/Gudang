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
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><i class="fa fa-edit"></i> &ensp; Form Data Barang</h5>
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
      <form action="{{ route('Stuff.store') }}" method="post">
        @csrf
        <div class="row">
          <div class="form-group col-md-6 col-lg-6">
            <label for="">Nama Barang : <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Masukan Nama Barang..." required autofocus>
            <span class="text-danger">
              {{ $errors->first('name') }}
            </span>
          </div>
          <div class="form-group col-md-3 col-lg-3">
            <label for="">Kategori Barang : <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;" data-placeholder="Pilih Kategori Barang" required>
              <option value=""></option>
              @foreach ($category as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-3 col-lg-3">
            <label for="">Gudang Penyimpanan : <span class="text-danger">*</span></label>
            <select name="storage_id" id="storage_id" class="form-control select2" style="width: 100%;" data-placeholder="Pilih Lokasi Gudang" required>
              <option value=""></option>
              @foreach ($storage as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-12">
            <label for="">Deskripsi Barang : <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}" placeholder="Masukan Deskripsi Barang..." required></textarea>
          </div>
          <div class="form-group col-12">
            <hr class="mt-0 mb-2">
            <div class="row">
              <div class="col-md-2 col-lg-2">
                <button type="submit" class="btn btn-outline-success btn-block mt-1">
                  <i class="fa fa-plus"></i> &ensp;
                  Tambah Data
                </button>
              </div>
              <div class="col-md-2 col-lg-2">
                <button type="submit" class="btn btn-outline-danger btn-block mt-1">
                  <i class="fa fa-undo"></i> &ensp;
                  Reset Input
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
  <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {      
      $('.select2').select2().on('select2:open', () => {
        $(".select2-results:not(:has(button))").append(`
        <button class="btn btn-outline-secondary btn-block flat" style="border-bottom-left-radius: 1px !important; border-bottom-right-radius: 1px !important;">
          Buat Data Baru
        </button>
        `
        );
      });

      $('#storage_id').select2().on('select2:open', () => {
        $(".select2-results:not(:has(button))").append(`
        <button class="btn btn-outline-secondary btn-block flat" style="border-bottom-left-radius: 1px !important; border-bottom-right-radius: 1px !important;">
          Buat Data Baru
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
    });
  </script>
@endsection