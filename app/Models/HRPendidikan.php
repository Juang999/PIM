<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRPendidikan extends Model
{
    use HasFactory;

    protected $table = 'hris.hr_pendidikan';

    protected $keyType = 'string';

    protected $primaryKey = 'hrpend_oid';

    protected $guarded = [];

    public $timestamps = false;
}
