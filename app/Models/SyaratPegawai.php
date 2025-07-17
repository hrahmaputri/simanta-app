<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyaratPegawai extends Model
{
    protected $table = 'tbl_syarat_pegawai';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
