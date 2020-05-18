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
@endsection

@section('script')
{{ $dataTable->scripts() }}
<script>
  $(document).ready(function() {
    // $('#users-table').removeClass('dataTable');
    // $('#users-table').removeClass('no-footer');
  });
</script>
@endsection