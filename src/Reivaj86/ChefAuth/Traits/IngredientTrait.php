<?php

namespace Reivaj86\ChefAuth\Traits;

trait IngredientTrait
{
    /**
     * Ingredient belongs to many categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('Reivaj86\ChefAuth\Models\Categories')->withTimestamps();
    }

    /**
     * Ingredient belongs to many recipes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipes()
    {
        return $this->belongsToMany(Config::get('auth.model'))->withTimestamps();
    }

    /**
     * Attach categorie to an ingredient.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Category $category
     * @return int|bool
     */
    public function attachCategory($category)
    {
        return (!$this->categories()->get()->contains($category)) ? $this->categories()->attach($category) : true;
    }

    /**
     * Detach categorie from an ingredient.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Category $category
     * @return int
     */
    public function detachCategory($category)
    {
        return $this->categories()->detach($category);
    }

    /**
     * Detach all categories.
     *
     * @return int
     */
    public function detachAllCategories()
    {
        return $this->categories()->detach();
    }
}
