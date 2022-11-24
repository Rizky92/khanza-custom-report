<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bangsal extends Model
{
    protected $primaryKey = 'kd_bangsal';

    protected $keyType = 'string';

    protected $table = 'bangsal';

    public $incrementing = false;

    public $timestamps = false;
}
