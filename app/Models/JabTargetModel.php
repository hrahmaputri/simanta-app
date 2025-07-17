<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabTargetModel extends Model
{
    protected $table = 'tbl_jab_target';
    protected $primaryKey = 'id_target';
    protected $keyType = 'integer';

    protected $fillable = [
        'id_target',
        'id_jabatan'
    ];

    public $incrementing = true;
    public $timestamps = true;
}
