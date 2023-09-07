<?php

namespace App\Models\Keuangan\RKAT;

use App\Support\Eloquent\Concerns\Searchable;
use App\Support\Eloquent\Concerns\Sortable;
use App\Support\Eloquent\Model;

class PemakaianAnggaranDetail extends Model
{
    use Sortable, Searchable;

    /**
     * The connection name for the model.
     *
     * @var ?string
     */
    protected $connection = 'mysql_smc';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pemakaian_anggaran_detail';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 25;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nominal',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'nominal' => 'float',
    ];

    /** 
     * @var string[]
     */
    protected $searchColumns = [
        'keterangan',
    ];
}
