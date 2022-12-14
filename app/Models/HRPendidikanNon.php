<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRPendidikanNon extends Model
{
    use HasFactory;

    protected $table = 'hris.hr_pendidikan_non';

    protected $keyType = 'string';

    protected $primaryKey = 'hrpendn_oid';

    protected $guarded = [];

    public $timestamps = false;
}
