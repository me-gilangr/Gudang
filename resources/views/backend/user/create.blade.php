@extends('backend.layouts.master')

@section('css')
  <link rel="stylesheet" href="{{ asset('backend') }}/other/datepicker/bootstrap-datepicker.min.css">
@endsection

@section('content')
<div class="col-12">
  <div class="card card-primary card-outline">
    <div class="card-header"> 
      <h5 class="card-title m-0"> <i class="fa fa-edit"></i> &ensp; Form Data User</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button> 
        <a href="{{ route('User.index') }}" class="btn btn-tool">
          <i class="fas fa-times"></i> &ensp; Kembali
        </a>
      </div> 
    </div>
    <div class="card-body"> 
      <form action="{{ route('User.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="form-group col-12">
            <h4>Data Diri User</h4>
            <hr class="m-0">
          </div>
          <div class="form-group col-md-5 col-lg-5">
            <label for="">Nama Lengkap : <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" value="{{ old('name') }}" placeholder="Masukan Nama Lengkap..." autofocus required>
            <span class="text-danger">
              {{ $errors->first('name') }}
            </span>
          </div>
          <div class="form-group col-md-4 col-lg-4">
            <label for="">Tanggal Lahir : <span class="text-danger">*</span></label>
            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid':'' }}" value="{{ old('date_of_birth') }}" placeholder="Masukan Tangal Lahir..." readonly required style="background-color: #ffffff;">
            <span class="text-danger">
              {{ $errors->first('date_of_birth') }}
            </span>
          </div>
          <div class="form-group col-md-3 col-lg-3">
            <label for="">Jenis Kelamin : <span class="text-danger">*</span></label>
            <select name="gender" id="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid':'' }}" required>
              <option value="">- Pilih Jenis Kelamin -</option>
              @foreach ($gender as $item)
                <option value="{{ $item }}" {{ old('gender') == $item ? 'selected':'' }}>{{ ucfirst($item) }}</option>
              @endforeach
            </select>
            <span class="text-danger">
              {{ $errors->first('gender') }}
            </span>
          </div>
          <div class="col-md-5 col-lg-5">
            <div class="form-group">
              <label for="">Nomor Telfon : <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">( +62 )</span>
                </div>
                <input type="text" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}" value="{{ old('phone') }}" placeholder="Masukan Nomor Telfon..." required>
              </div>
              <span class="text-danger">
                {{ $errors->first('phone') }}
              </span>
            </div>
            <div class="form-group">
              <label for="">Photo : </label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="photo" id="photo" class="custom-file-input {{ $errors->has('photo') ? 'is-invalid':'' }}" id="exampleInputFile" value="{{ old('photo') }}">
                  <label class="custom-file-label" for="exampleInputFile">Pilih File...</label>
                </div> 
              </div>
              <span class="text-danger">
                {{ $errors->first('photo') }}
              </span>
            </div>
          </div>
          <div class="form-group col-md-7 col-lg-7">
            <label for="">Alamat : <span class="text-danger">*</span></label>
            <textarea name="address" id="address" class="form-control {{ $errors->has('address') ? 'is-invalid':'' }}" rows="4" placeholder="Masukan Alamat..." style="height: 121px; max-height:121px; min-height: 121px;" required>{{ old('address') }}</textarea>
            <span class="text-danger">
              {{ $errors->first('address') }}
            </span>
          </div>
          <div class="form-group col-12">
            <hr class="m-0">
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="form-group">
              <label for="">E-Mail : <span class="text-danger">*</span></label>
              <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" value="{{ old('email') }}" placeholder="Masukan E-Mail..." required>
              <span class="text-danger">
                {{ $errors->first('email') }}
              </span>
            </div>
            <div class="form-group">
              <label for="">Konfirmasi E-Mail : <span class="text-danger">*</span></label>
              <input type="email" name="email_confirmation" id="email_confirmation" class="form-control {{ $errors->has('email_confirmation') ? 'is-invalid':'' }}" placeholder="Silahkan Tulis Ulang E-Mail..." required>
              <span class="text-danger">
                {{ $errors->first('email_confirmation') }}
              </span>
            </div>
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="form-group">
              <label for="">Password : <span class="text-danger">*</span></label>
              <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Masukan Password..." required>
              <span class="text-danger">
                {{ $errors->first('password') }}
              </span>
            </div>
            <div class="form-group">
              <label for="">Konfirmasi Ulang Password : <span class="text-danger">*</span></label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid':'' }}" placeholder="Tulis Ulang Password..." required>
            </div>
          </div>
          <div class="form-group col-12">
            <label for="">Hak Akses User : </label>
            @foreach ($role as $item)
              <div class="form-check ml-1">
                <input type="radio" name="role" id="role{{ $loop->iteration }}" class="form-check-input" value="{{ $item->name }}" required {{ old('role') == $item->name ? 'checked':'' }}>
                <label for="role{{ $loop->iteration }}">{{ $item->name }}</label>
              </div>
            @endforeach
          </div>
          <div class="form-group col-12">
            <hr class="mt-0">
            <div class="row">
              <div class="col-md-3 col-lg-3 mt-1">
                <button type="submit" class="btn btn-outline-primary btn-sm btn-block">
                  <span class="fa fa-plus" style="padding-top: 4px;"></span> &ensp; Tambah Data
                </button>
              </div>
              <div class="col-md-3 col-lg-3 mt-1"> 
                <button type="reset" class="btn btn-outline-warning btn-sm btn-block" onclick="document.getElementById('name').focus();">
                  <span class="fa fa-undo"></span> &ensp; Reset Input
                </button>
              </div>
              <div class="col-md-3 col-lg-3 mt-1">
                <a href="{{ route('User.index') }}" class="btn btn-outline-danger btn-sm btn-block">
                  <span class="fa fa-times"></span> &ensp; Batal 
                </a>
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
  <script src="{{ asset('backend') }}/other/datepicker/bootstrap-datepicker.min.js"></script>
  <script> 
  $(document).ready(function() {
    $('#date_of_birth').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      endDate: '0d',
      todayHighlight: true,
      disableTouchKeyboard: true,
      orientation: 'auto bottom',
    });

    $('#photo').on('change', function() {
      if ($(this).val() == '') {
        $('.custom-file-label').text('Pilih File...');
      } else {
        var name = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('.custom-file-label').text(name);
      }
    });
  }); 
  </script>
@endsection