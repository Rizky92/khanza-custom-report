<?php

namespace App\Models\Farmasi\Inventaris;

use App\Support\Eloquent\Model;

class IndustriFarmasi extends Model
{
    protected $connection = 'mysql_sik';

    protected $primaryKey = 'kode_industri';

    protected $keyType = 'string';

    protected $table = 'industrifarmasi';

    public $incrementing = false;

    public $timestamps = false;
}
