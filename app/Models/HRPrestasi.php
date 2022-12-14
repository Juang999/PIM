<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRPrestasi extends Model
{
    use HasFactory;

    protected $table = 'hris.hr_prestasi';

    protected $keyType = 'string';

    protected $primaryKey = 'hrpres_oid';

    protected $guarded = [];

    public $timestamps = false;
}
