<?php

namespace Reivaj86\ChefAuth\Traits;

trait CategoryTrait
{
    /**
     * Category belongs to many ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('Reivaj86\ChefAuth\Models\Ingredient')->withTimestamps();
    }

    /**
     * Category belongs to many recipes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipes()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps();
    }
}
