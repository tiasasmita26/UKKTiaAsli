<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\PhotoComment;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;

class PhotoController extends Controller
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
        $fotos = Photo::all();
        return view('admin.data-foto.index', ['fotos' => $fotos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $albums = Album::get();
        $fotos = Photo::all();
        return view ('admin.data-foto.create', compact('albums', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $massages = [
            'required' => 'Silahkan isi kolom ini !',
            'max' => 'Tidak boleh lebih dari 100 karakter',
            'image' => 'Anda hanya dapat menambahkan gambar',
        ];

        $request->validate([
            'judulfoto' => 'required|max:255',
            'deskripsifoto' => 'required|max:255',
            'lokasifile' => 'image|required',
            'albumId' => 'required', 
        ], $massages);
        $tanggal = Carbon::now()->toDateTimeString();
        $fotos = new Photo;
        $fotos->judulfoto = $request->judulfoto;
        $fotos->deskripsifoto = $request->deskripsifoto;
        $fotos->lokasifile = $request->lokasifile;
        $fotos->tanggalunggah = $tanggal;
        $fotos->albumId = $request->albumId;
        $fotos['userId'] = auth()->user()->userId;

        if ($request->hasFile('file_location')) {
            $files = $request->file('file_location');
            $path = storage_path('app/public');
            $files_name = 'public' . '/' . date('Ymd') . '-' .
            $files->getClientOriginalName();
            $files->storeAs('public', $files_name);
            $fotos->file_location = $files_name;
        }

        $fotos->save();

        return redirect('/admin/data-foto')->with('success', 'tambah data sukses!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $fotos = Photo::where('fotoId',$id)->first();
        $likes = Like::where('fotoId', $id)->count();
        $fotoId = $id;
        $komentar = PhotoComment::where('fotoId', $id)->get();
        return view('detail.index', compact(['foto', 'like', 'fotoId', 'komentar']));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */ 
    public function edit(int $fotoId)
    {
        $fotos = Photo::where('fotoId', $fotoId)->first();
        $user = User::all();
        $albums = Album::get();
        
    // Periksa jika album ditemukan
    if (!$fotos) {
        abort(404); // Tampilkan halaman 404 jika album tidak ditemukan
    }

    return view('/admin.data-foto.edit', compact(['fotos']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $fotoId)
{
    $tanggal = Carbon::now()->toDateTimeString();
    
    $fotos = Photo::where('fotoId', $fotoId)->first();
    
    $fotos->judulfoto = $request->judulfoto;
    $fotos->deskripsifoto = $request->deskripsifoto;
    $fotos->albumId = $request->albumId;
    
    if ($request->hasFile('file_location')) {
        $file = $request->file('file_location');
        $path = storage_path('app/public');
        $file_name = 'public/' . date('Ymd') . '-' . $file->getClientOriginalName();
        $file->storeAs('public', $file_name);
        $fotos->file_location = $file_name;
    }

    $fotos->userId = auth()->user()->userId;

    $fotos->save();

    return redirect('/admin/data-foto')->with('success', 'foto telah diperbarui!');
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy($fotoId)
    {
        Photo::destroy($fotoId);
        return redirect('/admin/data-foto')->with('success','Data Berhasil Dihapus');
    }


}