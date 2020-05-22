@extends('backend.layouts.master')

@section('content')
<div class="col-md-3 col-lg-3 d-none d-sm-none .d-md-block d-lg-block">
  <div class="card card-info card-outline">
    <div class="card-body box-profile">
      <div class="text-center"> 
        <a href="{{ $user->photo != null ? asset('images/users').'/'. $user->photo:asset('images/no-image.png') }}" data-lightbox="user-photo" data-title="Foto : {{ $user->name }}">
          <img src="{{ $user->photo != null ? asset('images/users').'/'. $user->photo:asset('images/no-image.png') }}" class="profile-user-img img-fluid img-circle" alt="{{ $user->name }}" style="max-height: 150px;">
        </a>
      </div>

      <h3 class="profile-username text-center">{{ $user->name }}</h3>

      <p class="text-muted text-center">{{ $user->roles->first()->name }}</p>

      <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item text-center">
          {{ $user->email }}
        </li>
        <li class="list-group-item text-center">
          (+62) {{ $user->phone }}
        </li> 
      </ul>

      <a href="{{ route('User.edit', $user->id) }}" class="btn btn-outline-warning btn-block"><i class="fa fa-edit"></i> &ensp; Edit Data</a>
    </div>
    <!-- /.card-body -->
  </div>
</div>
<div class="col-md-9 col-lg-9">
  <div class="card card-info card-outline">
    <div class="card-header"> 
      <h5 class="card-title m-0"> <i class="fa fa-user"></i> &ensp; Detail Data User</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button> 
        <a href="{{ route('User.index') }}" class="btn btn-tool">
          <i class="fas fa-times"></i> &ensp; Kembali
        </a>
      </div> 
    </div>
    <div class="card-body box-profile">
      <div class="row">
        <div class="col-12 d-block d-sm-block .d-md-none d-lg-none text-center">
          <a href="{{ asset('images/users') }}/{{ $user->photo }}" data-lightbox="user-photo" data-title="Foto : {{ $user->name }}">
            <img src="{{ asset('images/users') }}/{{ $user->photo }}" class="profile-user-img img-fluid img-circle" alt="{{ $user->name }}" style="max-height: 150px;">
          </a>
          
          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->roles->first()->name }}</p>
        </div>
        <div class="col-12 d-block d-sm-block .d-md-none d-lg-none text-center">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>E-Mail</td>
                <td>:</td>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $user->gender }}</td>
              </tr>
              <tr>
                <td>Nomor Telfon</td>
                <td>:</td>
                <td>(+62) {{ $user->phone }}</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $user->address }}</td>
              </tr>
              <tr>
                <td colspan="3">
                  <a href="{{ route('User.edit', $user->id) }}" class="btn btn-outline-warning btn-block"><i class="fa fa-edit"></i> &ensp; Edit Data</a>
                </td>
              </tr>
            </table>
          </div>
        </div>
        
        <div class="col-12 d-none d-sm-none .d-md-block d-lg-block text-center">
          <div class="table-responsive">
            <table class="table"> 
              <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $user->gender }}</td>
              </tr>
              <tr>
                <td>Nomor Telfon</td>
                <td>:</td>
                <td>(+62) {{ $user->phone }}</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $user->address }}</td>
              </tr> 
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection