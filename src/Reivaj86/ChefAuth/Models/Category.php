<?php

namespace Reivaj86\ChefAuth\Models;

use Reivaj86\ChefAuth\Traits\SlugableTrait;
use Illuminate\Database\Eloquent\Model;
use Reivaj86\ChefAuth\Traits\CategoryTrait;
use Reivaj86\ChefAuth\Contracts\CategoryContract;

class Category extends Model implements CategoryContract
{
    use CategoryTrait, SlugableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'model', 'img'];

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
