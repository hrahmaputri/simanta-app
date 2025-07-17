<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PegawaiData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $keyType = 'integer';

    protected $fillable = [
        'id_pegawai',
        'nip',
        'nip_lama',
        'nama_pegawai',
        'tanggal_lahir',
        'id_status_kepegawaian',
        'id_pangkat',
        'id_jabatan',
        'id_skpd',
        'gelar_depan',
        'gelar_belakang',
        'id_pendidikan',
        'id_hukuman',
        'id_jenjang_jabfung',
        'jam_jp',
        'id_pengguna',
        'cek_update'
    ];

    public $incrementing = true;
    public $timestamps = true;
}
