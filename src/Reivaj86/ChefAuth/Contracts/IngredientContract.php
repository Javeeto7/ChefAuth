<?php

namespace Reivaj86\ChefAuth\Contracts;

interface IngredientContract
{
    /**
     * Ingredient belongs to many categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories();

    /**
     * Ingredient belongs to many Recipes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipes();

}
