@extends('admin.main')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h4>Form Edit</h4>
            </div>
            <form method="post" action="/admin/data-foto/{{$fotos->fotoId}}" class="mb-5" enctype="multipart/form-data">
            @method('PUT')
            @csrf

        <div class="card-body">
            <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul Foto</label>
                <div class="col-sm-12 col-md-7">
            <input type="text" name="judulfoto" class="form-control" required value="{{old('judulfoto', $fotos->judulfoto)}}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi Foto</label>
            <div class="col-sm-12 col-md-7">
                <input type="text" name="deskripsifoto" class="form-control" required value="{{old('deskripsifoto', $fotos->deskripsifoto)}}">
                </div>
                </div>
                <div class="card-body">
                <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi File</label>
                <div class="col-sm-12 col-md-7">
                <input type="text" name="lokasifile" class="form-control" required value="{{old('lokasifile', $fotos->lokasifile)}}">
                </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Album Id</label>
                    <div class="col-sm-12 col-md-7">
                      <select name="albumId" class="form-control selectric">
                       <option disable value="">Pilih Album</option>
                       @foreach ($albums as $item)
                           <option value="{{ $item->albumId }}">{{ $item->namaalbum }}</option>
                       @endforeach
                      </select>
                    </div>
                  </div>
              <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary">Ubah</button>
            </div>
          </div>
                  </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection