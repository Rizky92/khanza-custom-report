<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @template TModel as class-string<\Illuminate\Database\Eloquent\Model>
 */
class DoesntExist implements Rule
{
    /**
     * @var TModel
     */
    private string $model;

    /**
     * @var string
     */
    private string $column;

    /**
     * Create a new rule instance.
     * 
     * @param  TModel $model
     * @param  string $column
     */
    public function __construct(string $model, string $column)
    {
        $this->model = $model;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! $this->model::where($this->column, $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $model = str(class_basename($this->model))
            ->headline()
            ->value();

        return ":Attribute tidak boleh menggunakan {$model} yang sudah ada!";
    }
}
