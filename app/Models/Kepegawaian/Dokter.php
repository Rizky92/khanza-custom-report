<?php

namespace App\Models\Kepegawaian;

use App\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $connection = 'mysql_sik';

    protected $primaryKey = 'kd_dokter';

    protected $keyType = 'string';

    protected $table = 'dokter';

    public $incrementing = false;

    public $timestamps = false;

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kd_dokter', 'kd_dokter');
    }

    public function registrasi(): HasMany
{
    return $this->hasMany(RegistrasiPasien::class, 'kd_dokter', 'kd_dokter');
}
}


