<?php

namespace Reivaj86\ChefAuth\Models;

use Reivaj86\ChefAuth\Contracts\ChefAuthContract;
use Reivaj86\ChefAuth\Contracts\HasIngredientContract;
use Reivaj86\ChefAuth\Traits\HasIngredient;
use Reivaj86\ChefAuth\Traits\SlugableTrait;
use Illuminate\Database\Eloquent\Model;


class Recipe extends Model implements HasIngredientContract, ChefAuthContract
{
    use HasIngredient, SlugableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'img', 'level'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('chef-auth.connection')) { $this->connection = $connection; }
    }
}
