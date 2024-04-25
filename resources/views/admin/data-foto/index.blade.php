@extends('admin.main')
@section('content')

<div class="card">
    <div class="card-header">
        <a href="/admin/data-foto/create" class="btn btn-icon icon-left btn-warning"><i class="far fa-edit"></i> Tambah Foto </a>
    </div>
        <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Judul Foto</th>
                <th scope="col">Deskripsi Foto</th>
                <th scope="col">Tanggal Unggah</th>
                <th scope="col">Lokasi File</th>
                <th scope="col">Album ID</th>
                <th scope="col">User ID</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($fotos as $fotos)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$fotos->judulfoto}}</td>
              <td>{{$fotos->deskripsifoto}}</td>
              <td>{{$fotos->tanggalunggah}}</td>
              <td>{{$fotos->lokasifile}}</td>
              <td>{{$fotos->albumId}}</td>
              <td>{{$fotos->userId}}</td>
              <td>
                <div class="btn-group" role="group">
                    <a href="/admin/data-foto/{{ $fotos->fotoId }}/edit" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i></a>

                    <form action="/admin/data-foto/{{ $fotos->fotoId }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-outline-danger" onclick="return confirm('Yakin akan dihapus??')"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
                </td>
            </tr>
            @endforeach
            </tbody>    
        </table>
        </div>
</div>
@endsection