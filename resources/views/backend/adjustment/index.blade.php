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

  .select2-container--default .select2-selection--single {
    border-radius: 0px;
  }
  .select2-container--default .select2-results>.select2-results__options {
    max-height: 150px !important;
  }

  .redBorder {
    border-color: red !important;
  }

  .btn-tool-action {
    font-size: .875rem;
    margin: -.75rem 0;
    padding: .25rem .5rem;
  }
  
  .btn-tool-action:hover {
    color: #fff !important;
  }
</style>
@endsection

@section('content')
<div class="col-12">
  <div class="card card-info card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0"> 
      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item text-black">
          <a class="nav-link">
            <i class="fa fa-boxes"></i> &ensp; Form Adjustment Transaksi
          </a>
        </li>
        <li class="nav-item text-black">
          <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"> <i class="fa fa-sign-in-alt"></i> &ensp; Barang Masuk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"> <i class="fa fa-sign-out-alt"></i> &ensp; Barang Keluar</a>
        </li> 
        <li class="nav-item">
        </li>
        <li class="ml-auto">
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>  
          </div>
        </li>
      </ul> 
    </div> 
    <div class="card-body"> 
      <div class="tab-content" id="custom-tabs-four-tabContent">
        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
          <div class="row">
            <div class="form-group col-12">
              <label for="">Data Transaksi Barang Masuk : <span class="text-danger">*</span></label>
              <select name="barang_masuk" id="barang_masuk" class="form-control select2 flat" style="width: 100%;" data-placeholder="Pilih Data Transaksi" required>
                <option value=""></option>
                @foreach ($bm as $item)
                  <option value="{{ $item->id }}">Kode : {{ $item->code }} || Data Transaksi </option>
                @endforeach
                <span class="text-danger empty_st" style="display: none">
                  Silahkan Pilih Data Transaksi !
                </span> 
              </select>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
          XZ
        </div> 
      </div> 
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
    $('#barang_masuk').select2().on('select2:open', () => {
      $(".select2-results:not(:has(button))").append(`
      <button class="btn btn-outline-info btn-block flat refresh mt-2">
        <i class="fa fa-undo"></i> &ensp; Refresh Data
      </button> 
      `
      );
      $('.select2-results').on('click', '.refresh', function() {
        $('#barang_masuk').select2('close');
        // getStuff();
      });
    }); 
  });
</script>
@endsection