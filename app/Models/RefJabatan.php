<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefJabatan extends Model
{
    protected $table = 'ref_jabatan';
    protected $primaryKey = 'id_jabatan';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
