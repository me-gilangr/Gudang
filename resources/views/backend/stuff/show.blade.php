@extends('backend.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('backend') }}/other/dropzone/dist/dropzone.css">
<style>
  .imagewrap {display:inline-block;position:relative;}
  .cornerButton{position:absolute;top:0;right:0;}
</style>
@endsection

@section('content')
<div class="col-md-9 col-lg-9">
  <div class="card card-info card-outline">
    <div class="card-header"> 
      <h5 class="card-title m-0"> <i class="fa fa-box"></i> &ensp; Detail Data Barang</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button> 
        <a href="{{ route('Stuff.index') }}" class="btn btn-tool">
          <i class="fas fa-times"></i> &ensp; Kembali
        </a>
      </div> 
    </div>
    <div class="card-body box-profile">
      <div class="row">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td width="20%">Nama Barang</td>
              <td width="5%">:</td>
              <td class="text-left">{{ $stuff->name }}</td>
            </tr>
            <tr>
              <td width="20%">Kategori Barang</td>
              <td width="5%">:</td>
              <td class="text-left">{{ $stuff->category->name }}</td>
            </tr>
            <tr>
              <td width="20%">Lokasi Gudang </td>
              <td width="5%">:</td>
              <td class="text-left">{{ $stuff->storage->name }}</td>
            </tr>
            <tr>
              <td width="20%">Deskripsi</td>
              <td width="5%">:</td>
              <td class="text-left">{{ $stuff->description }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="card card-info card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0"> 
      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item text-black">
          <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"> <i class="fa fa-image"></i> &ensp; Data Foto Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"> <i class="fa fa-upload"></i> &ensp; Upload Foto Barang</a>
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
    <div class="card-body box-profile pt-1"> 
      <div class="tab-content" id="custom-tabs-four-tabContent">
        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
          <div class="row imageList">
            @forelse ($stuff->image as $item)
              <div class="col-xs-2 col-sm-2 col-md-3 col-lg-4 text-center">
                <div class="imagewrap">
                  <a href="{{ asset('images/stuff').'/'. $item->name }}" class="light" data-lightbox="stuff-photo" data-title="Foto : {{ $stuff->name }}" >
                    <img src="{{ asset('images/stuff').'/'. $item->name }}" alt="{{ $stuff->name }}" class="img-fluid mt-1" style="max-height: 150px;">
                  </a>
                  <button class="cornerButton btn btn-sm btn-danger hapus" data-id="{{ $item->id }}"> 
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              </div>
            @empty
              <div class="col-12 p-3">
                <h5 class="text-center">
                  Barang Belum Memiliki Foto
                </h5>
              </div>
            @endforelse
          </div>
        </div>
        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
          <form class="m-dropzone dropzone m-dropzone--primary" method="POST" action="{{ route('ImageStuff.store', $stuff->id) }}" id="m-dropzone-two" enctype="multipart/form-data">
            <div class="m-dropzone__msg dz-message needsclick">
              <h3 class="m-dropzone__msg-title">
                Jatuhkan File / Klik disini untuk mengupload Foto Barang.
              </h3>
              <span class="m-dropzone__msg-desc">
                Maximum file yang dapat di-upload : 10
              </span>
            </div>
            @csrf
          </form>
        </div> 
      </div> 
    </div>
  </div>
</div>
<div class="col-md-3 col-lg-3">
  <div class="card card-success card-outline">
    <div class="card-body box-profile"> 
      <h3 class="profile-username text-center">Kartu Stok</h3>

      @if ($stock != null)
      <p class="text-muted text-center"> Periode : {{ date('M Y', strtotime($stock->stock_date)) }}</p>

      <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
          <span class="pl-1">Stok Modal &ensp; :</span>
          <span class="float-right pr-1">{{ $stock->cap_stock }} Unit</span>
        </li>
        <li class="list-group-item">
          <span class="pl-1">Stok Masuk &ensp; :</span>
          <span class="float-right pr-1">{{ $stock->stock_entry }} Unit</span>
        </li>
        <li class="list-group-item">
          <span class="pl-1">Stok Keluar &ensp; :</span>
          <span class="float-right pr-1">{{ $stock->stock_out }} Unit</span>
        </li>
        {{-- <li class="list-group-item">
          <span class="pl-1">Stok Return-In &ensp; :</span>
          <span class="float-right pr-1">{{ $stock->stock_back_in }} Unit</span>
        </li>
        <li class="list-group-item">
          <span class="pl-1">Stok Return-Out &ensp; :</span>
          <span class="float-right pr-1">{{ $stock->stock_back_out }} Unit</span>
        </li> --}}
        <li class="list-group-item">
          <span class="pl-1">Stok Penyesuaian &ensp; :</span>
          <span class="float-right pr-1">{{ $stock->stock_adjustment }} Unit</span>
        </li>
      </ul>

      <a href="#" class="btn btn-outline-success btn-block"><i class="fa fa-edit"></i> &ensp; Detail Kartu Stock</a>
      @else
        <p class="text-muted text-center"> Belum Ada Kartu Stok Untuk Periode Bulan Ini</p>
        <a href="#" class="btn btn-outline-success btn-block"><i class="fa fa-plus"></i> &ensp; Atur Kartu Stock</a>
      @endif
    </div> 
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('backend') }}/other/dropzone/dist/dropzone.js"></script>
<script>
function getImage() {
		$.ajax({
			url: "{{ route('ImageStuff.image', $stuff->id) }}",
			method: "GET",
			success: function(data) {
				if (data.empty) {
					$('.imageList').empty();
					$('.imageList').append(`
            <div class="col-12 p-3">
              <h5 class="text-center">
                Barang Belum Memiliki Foto
              </h5>
            </div>
					`);
				} else {
					$('.imageList').empty();
					data.forEach(item => {
						$('.imageList').append(`
            <div class="col-xs-2 col-sm-2 col-md-3 col-lg-4 text-center">
              <div class="imagewrap">
                <a href="{{ asset('images/stuff') }}/${item.name}" data-lightbox="stuff-photo" data-title="Foto : {{ $stuff->name }}" >
                  <img src="{{ asset('images/stuff')}}/${item.name}" alt="{{ $stuff->name }}" class="img-fluid mt-1" style="max-height: 150px;">
                </a>
                <button class="cornerButton btn btn-sm btn-danger hapus" data-id="${item.id}"> 
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </div> 
						`);
					});
				}
			}
		});
	}
</script>
<script>
  Dropzone.options.mDropzoneTwo =
  {
    maxFiles: 10,
    maxFilesize: 10,
    acceptedFiles: ".jpeg,.jpg,.png",
    timeout: 5000,
    success: function(file, response) 
    {
      if (response.success) {
        toastSuccess(response.success);
        getImage();
      }
  
      if (response.error) {
        toastError(response.error); 
      }
    },
    error: function(file, response)
    {
      toastError("File Upload Harus Berupa JPG / JPEG / PNG !");
      console.log(file);
      console.log(response);
      return false;
    },
    complete: function(file) {
      this.removeFile(file);
    }
  };

  $('.imageList').on('click', '.hapus', function(e) {
    id = $(this).data('id');
    $.ajax({
      url: "{{ route('ImageStuff.delete', $stuff->id) }}",
      method: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        _method: "DELETE",
        id: id,
      },
      success: function(data) { 
        if (data.error) {
          toastError(data.error);
        }
        if (data.success) {
          getImage();
          toastWarning(data.success);
        }
      }
    });
  });

</script>
@endsection