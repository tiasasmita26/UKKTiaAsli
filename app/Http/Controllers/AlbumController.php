<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Carbon\Carbon;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $albums = Album::all();
        return view('admin.album.index', ['album' => $albums]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'required' => 'Silahkan isi kolom ini!'
        ];
        $validatedData = $request->validate([
            'namaalbum' => 'required|max:255', 
            'deskripsi' => 'required|max:255', 
        ],$message
        
    );
    $tanggal = Carbon::now()->toDateTimeString();
        
        // insert data ke database
        $albums = new Album;
        $albums->namaalbum = $validatedData['namaalbum'];
        $albums->deskripsi = $validatedData['deskripsi'];
        if(Auth::check()){
        $albums->userId = $validatedData['userId'] = auth()->user()->userId;
        }
        $albums->tanggaldibuat = $tanggal;
        $albums->save();
        

        return redirect('/admin/album')->with('success', 'Kategori baru telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show($albums)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(int $albumId)
    {
    $albums = Album::where('albumId', $albumId)->first();
        
    // Periksa jika album ditemukan
    if (!$albums) {
        abort(404); // Tampilkan halaman 404 jika album tidak ditemukan
    }

    return view('/admin.album.edit', compact(['albums']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $albumId)
    {
        $tanggal = Carbon::now()->toDateTimeString();
        $albums = Album::where('albumId', $albumId)->first();
        $albums->namaalbum = $request->namaalbum;
        $albums->deskripsi = $request->deskripsi;
        
        if (Auth::check()) {
            $albums->userId = auth()->user()->userId;
        }
        
        // Tidak perlu memperbarui tanggal pembuatan
        $albums->save();
        
        return redirect('/admin/album')->with('success', 'Album telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy($albumId)
    {
        Album::destroy($albumId);
        return redirect('/admin/album')->with('success','Data Berhasil Dihapus');
    }
}