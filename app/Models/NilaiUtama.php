<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiUtama extends Model
{
    protected $table = 'tbl_nilai_utama';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public $incrementing = true;
    public $timestamps = true;
}
