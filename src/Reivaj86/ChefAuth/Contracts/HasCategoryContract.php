<?php

namespace Reivaj86\ChefAuth\Contracts;

interface HasCategoryContract
{
    /**
     * Ingredient belongs to many categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredientCategories();

    /**
     * Get all categories as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategories();


    /**
     * Check if the ingredient is cookable on recipe.
     *
     * @param string $providedCategorie
     * @param object $entity
     * @param bool $owner
     * @param string $ownerColumn
     * @return bool
     */
    public function cookable($providedCategory, $entity, $owner = true, $ownerColumn = 'ingredient_id');

    /**
     * Attach category to an ingredient.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Category $category
     * @return null|bool
     */
    public function attachCategory($category);

    /**
     * Detach category from an ingredient.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Permission $permission
     * @return int
     */
    public function detachCategory($category);

    /**
     * Detach all categories from an ingredient.
     *
     * @return int
     */
    public function detachAllCategories();

    /**
     * Get ingredient img of a categorie.
     *
     * @return int
     * @throws \Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException
     */
    public function img($category);
}
