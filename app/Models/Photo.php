<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $table = 'fotos';
    protected $primaryKey = 'fotoId';

    protected $fillable = ['judulfoto', 'deskripsifoto', 'tanggalunggah', 'lokasifile', 'albumId', 'userId'];

    public function user(){
        return $this->belongsTo(User::class, 'userId');
    }
}
