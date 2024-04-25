@extends('admin.main')
@section('content')

<div class="card">
    <div class="card-header">
    <a href="/admin/album/create" class="btn btn-icon icon-left btn-warning"><i class="far fa-edit"></i> Tambah Album </a>
    </div>
    <br>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Album</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Tanggal Dibuat</th>
            <th scope="col">UserID</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($album as $albums)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$albums->namaalbum}}</td>
              <td>{{$albums->deskripsi}}</td>
              <td>{{$albums->tanggaldibuat}}</td>
              <td>{{$albums->userId}}</td>
              <td>
                <div class="btn-group" role="group">
                    <a href="/admin/album/{{ $albums->albumId }}/edit" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i></a>

                    <form action="/admin/album/{{ $albums->albumId }}" method="POST" class="d-inline">
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
  </div>

@endsection