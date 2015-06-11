<?php

namespace Reivaj86\ChefAuth\Models;

use Reivaj86\ChefAuth\Contracts\HasCategoryContract;
use Reivaj86\ChefAuth\Traits\HasCategory;
use Reivaj86\ChefAuth\Traits\IngredientTrait;
use Reivaj86\ChefAuth\Traits\SlugableTrait;
use Illuminate\Database\Eloquent\Model;
use Reivaj86\ChefAuth\Contracts\IngredientContract;

class Ingredient extends Model implements IngredientContract, HasCategoryContract
{
    use IngredientTrait, SlugableTrait, HasCategory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'img'];

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
