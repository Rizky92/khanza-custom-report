<?php

namespace App\Models\Keuangan\RKAT;

use App\Support\Eloquent\Concerns\Searchable;
use App\Support\Eloquent\Concerns\Sortable;
use App\Support\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggaran extends Model
{
    use Sortable, Searchable, SoftDeletes;

    protected $connection = 'mysql_smc';

    protected $table = 'anggaran';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function anggaranBidang(): HasMany
    {
        return $this->hasMany(AnggaranBidang::class, 'anggaran_id', 'id');
    }
}
