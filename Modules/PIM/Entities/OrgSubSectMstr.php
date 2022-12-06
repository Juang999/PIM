<?php

namespace Modules\PIM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgSubSectMstr extends Model
{
    use HasFactory;

    protected $table = 'public.orgssect_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'ssect_oid';

    protected $guarded = [];

    public $timestamps = false;

    // protected static function newFactory()
    // {
    //     return \Modules\PIM\Database\factories\OrgSubSectMstrFactory::new();
    // }
}