<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefTkPendidikan extends Model
{
    protected $table = 'ref_tk_pendidikan';
    protected $primaryKey = 'id_tk_pendidikan';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
