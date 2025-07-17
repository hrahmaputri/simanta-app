<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimpelModel extends Model
{
    protected $table = 'tbl_simpel';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id_pegawai',
        'id_pengguna',
        'nip',
        'periode',
        'total_nilai'
    ];

    public $incrementing = true;
    public $timestamps = true;
}
