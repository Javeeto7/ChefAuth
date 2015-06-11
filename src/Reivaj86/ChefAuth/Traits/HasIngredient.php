<?php

namespace Reivaj86\ChefAuth\Traits;

use Reivaj86\ChefAuth\Models\Category;
use Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException;
use Reivaj86\ChefAuth\Exceptions\InvalidArgumentException;

trait HasIngredient
{
    /**
     * Property for caching ingredients.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $ingredients;


    /**
     * Recipe belongs to many ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredient()
    {
        return $this->belongsTo('Reivaj86\ChefAuth\Models\Ingredient')->withTimestamps();
    }
    /**
     * Recipe belongs to many ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('Reivaj86\ChefAuth\Models\Ingredient')->withTimestamps();
    }
    /**
     * Get ingredient as object.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getIngredient($ingredient)
    {
        return (!$this->ingredient) ? $this->ingredient = $this->ingredient()->get($ingredient) : $this->ingredient;
    }
    /**
     * Get all ingredients as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getIngredients()
    {
        return (!$this->ingredients) ? $this->ingredients = $this->ingredients()->get() : $this->ingredients;
    }

    /**
     * Check if the recipe has an ingredient or ingredients.
     *
     * @param int|string|array $ingredient
     * @param string $methodName
     * @return bool
     * @throws \Reivaj86\ChefAuth\Exceptions\InvalidArgumentException
     */
    public function cooks($ingredient, $methodName = 'One')
    {
        if ($this->isCookableEnabled()) { return $this->cookable('cooks'); }

        $this->checkChefMethodNameArgument($methodName);

        return $this->{'cooks' . ucwords($methodName)}($this->getChefArrayFrom($ingredient));
    }

    /**
     * Check if the recipe has at least one ingredient.
     *
     * @param array $ingredients
     * @return bool
     */
    protected function cooksOne(array $ingredients)
    {
        foreach ($ingredients as $ingredient) {
            if ($this->hasIngredient($ingredient)) { return true; }
        }

        return false;
    }

    /**
     * Check if the user has all ingredients.
     *
     * @param array $ingredients
     * @return bool
     */
    protected function cooksAll(array $ingredients)
    {
        foreach ($ingredients as $ingredient) {
            if (!$this->hasIngredient($ingredient)) { return false; }
        }

        return true;
    }

    /**
     * Check if the recipe has ingredient.
     *
     * @param int|string $ingredient
     * @return bool
     */
    protected function hasIngredient($ingredient)
    {
        return $this->getIngredients()->contains($ingredient) || $this->getIngredients()->contains('slug', $ingredient);
    }

    /**
     * Attach ingredient to a recipe.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Ingredient $ingredient
     * @return null|bool
     */
    public function attachIngredient($ingredient)
    {
        return (!$this->getIngredients()->contains($ingredient)) ? $this->ingredients()->attach($ingredient) : true;
    }

    /**
     * Detach ingredient from a recipe.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Ingredient $ingredient
     * @return int
     */
    public function detachIngredient($ingredient)
    {
        return $this->ingredients()->detach($ingredient);
    }

    /**
     * Detach all ingredients from a recipe.
     *
     * @return int
     */
    public function detachAllIngredients()
    {
        return $this->ingredients()->detach();
    }

    /**
     * Get ingredient img of a recipe.
     *
     * @return string
     * @throws \Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException
     */
    public function img($ingredient)
    {
        if ($ingredient = $this->getIngredients()->contains($ingredient)) { return $ingredient->img; }

        throw new IngredientNotFoundException('This recipe has no ingredient.');
    }

    /**
     * Get all categories from ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException
     */
    public function ingredientCategories()
    {
        if (!$ingredients = $this->getIngredients()->lists('id')) {
            throw new IngredientNotFoundException('This recipe has no ingredient.');
        }

        return Category::select([
            'categories.*',
            'category_ingredient.created_at as pivot_created_at',
            'category_ingredient.updated_at as pivot_updated_at'
        ])->join('category_ingredient', 'category_ingredient.ingredient_id', '=', 'categories.id')
            ->join('ingredients', 'ingredients.id', '=', 'categories_ingredient.ingredient_id')
            ->whereIn('ingredients.id', $ingredients)
            ->groupBy('categories.id');
    }

    private function isCookableEnabled()
    {
        return (bool) config('chef-auth.cookable.enabled');
    }

    /**
     * Allows to cookable or simulate package behavior.
     *
     * @param string $option
     * @return bool
     */
    private function cookable($option = null)
    {
        return (bool) config('chef-auth.cookable.options.' . $option);
    }

    /**
     * Get a chef array from argument.
     *
     * @param int|string|array $argument
     * @return array
     */
    private function getChefArrayFrom($argument)
    {
        if (!is_array($argument)) { return preg_split('/ ?[,|] ?/', $argument); }

        return $argument;
    }

    /**
     * Check chef methodName argument.
     *
     * @param string $methodName
     * @return void
     * @throws \Reivaj86\ChefAuth\Exceptions\InvalidArgumentException
     */
    private function checkChefMethodNameArgument($methodName)
    {
        if (ucwords($methodName) != 'One' && ucwords($methodName) != 'All') {
            throw new InvalidArgumentException('You can pass only strings [one] or [all] as a second parameter in [is] or [can] method.');
        }
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __callChef($method, $parameters)
    {
        if (starts_with($method, 'cooks')) {
            return $this->cooks(snake_case(substr($method, 5), config('chef-auth.separator')));
        } elseif (starts_with($method, 'is')) {
            return $this->is(snake_case(substr($method, 2), config('chef-auth.separator')));
        } elseif (starts_with($method, 'steamed')) {
            return $this->steamed(snake_case(substr($method, 7), config('chef-auth.separator')), $parameters[0], (isset($parameters[1])) ? $parameters[1] : true, (isset($parameters[2])) ? $parameters[2] : 'user_id');
        }

        return parent::__call($method, $parameters);
    }
}
