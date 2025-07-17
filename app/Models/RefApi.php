<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefApi extends Model
{
    protected $table = 'ref_api';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
