<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use NoProtocol\Encryption\MySQL\AES\Crypter;

class AESFromDatabaseCast implements CastsAttributes
{
    private Crypter $crypt;

    public function __construct(string $seed)
    {
        $this->crypt = new Crypter($seed);
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  mixed  $value
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $this->crypt->decrypt($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  mixed  $value
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $this->crypt->encrypt($value);
    }
}
