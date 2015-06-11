<?php

namespace Reivaj86\ChefAuth\Contracts;

interface HasIngredientContract
{
    /**
     * Recipe belongs to many ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients();

    /**
     * Recipe belongs to many ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredient();

    /**
     * Get all ingredients as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getIngredients();

    /**
     * Get ingredient as object.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getIngredient($ingredient);

    /**
     * Check if the recipe has an ingredient or ingredients.
     *
     * @param int|string|array $ingredient
     * @param string $methodName
     * @return bool
     * @throws \Reivaj86\ChefAuth\Exceptions\InvalidArgumentException
     */
    public function cooks($ingredient, $methodName = 'One');

    /**
     * Attach ingredient to a recipe.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Ingredient $ingredient
     * @return null|bool
     */
    public function attachIngredient($ingredient);

    /**
     * Detach ingredient from a recipe.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Ingredient $ingredient
     * @return int
     */
    public function detachIngredient($ingredient);

    /**
     * Detach all ingredients from a recipe.
     *
     * @return int
     */
    public function detachAllIngredients();

    /**
     * Get ingredient img of a recipe.
     *
     * @return int
     * @throws \Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException
     */
    public function img($ingredient);

    /**
     * Get all categories from ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException
     */
    public function ingredientCategories();


}
