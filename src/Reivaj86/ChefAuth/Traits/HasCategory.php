<?php

namespace Reivaj86\ChefAuth\Traits;

use Reivaj86\ChefAuth\Models\Category;
use Reivaj86\ChefAuth\Exceptions\IngredientNotFoundException;
use Reivaj86\ChefAuth\Exceptions\InvalidArgumentException;

trait HasCategory
{
    /**
     * Property for caching permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $category;

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


    /**
     * Get all categories as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategories()
    {
        return (!$this->categories)
            ? $this->categories = $this->ingredientCategories()->get()->merge($this->ingredientCategories()->get())
            : $this->categories;
    }

    /**
     * Check if the ingredient has a category or categories.
     *
     * @param int|string|array $category
     * @param string $methodName
     * @param string $from
     * @return bool
     * @throws \Reivaj86\ChefAuth\Exceptions\InvalidArgumentException
     */
    public function is($category, $methodName = 'One', $from = '')
    {
        if ($this->isCookableEnabled()) { return $this->cookable('is'); }

        $this->checkChefMethodNameArgument($methodName);

        return $this->{'is' . ucwords($methodName)}($this->getChefArrayFrom($category));
    }

    /**
     * Check if the ingredient has at least one category.
     *
     * @param array $categories
     * @return bool
     */
    protected function isOne(array $categories)
    {
        foreach ($categories as $category) {
            if ($this->hasCategory($category)) { return true; }
        }

        return false;
    }

    /**
     * Check if the ingredient has all categories.
     *
     * @param array $categories
     * @return bool
     */
    protected function isAll(array $categories)
    {
        foreach ($categories as $category) {
            if (!$this->hasCategory($category)) { return false; }
        }

        return true;
    }

    /**
     * Check if the ingredient has a category.
     *
     * @param int|string $category
     * @return bool
     */
    protected function hasCategory($category)
    {
        return $this->getCategories()->contains($category) || $this->getCategories()->contains('slug', $category);
    }

    public function img($category)
    {
        if ($category = $this->getCategories()->contains($category)) { return $category->img; }

        throw new CategoryNotFoundException('This recipe has no categories.');
    }
    /**
     * Check if the ingredient is steamed to manipulate with entity.
     *
     * @param string $providedCategory
     * @param object $entity
     * @param bool $owner
     * @param string $ownerColumn
     * @return bool
     */
    public function steamed($providedCategory, $entity, $owner = true, $ownerColumn = 'ingredient_id')
    {
        if ($this->isCookableEnabled()) { return $this->cookable('steamed'); }

        if ($owner === true && $entity->{$ownerColumn} == $this->id) { return true; }

        foreach ($this->getCategories() as $category) {
            if ($category->model != ''
                && get_class($entity) == $category->model
                && ($category->id == $providedCategory || $category->slug === $providedCategory)
            ) { return true; }
        }

        return false;
    }

    /**
     * Attach category to a ingredient.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Category $category
     * @return null|bool
     */
    public function attachCategory($category)
    {
        return (!$this->getCategories()->contains($category)) ? $this->ingredientCategories()->attach($category) : true;
    }

    /**
     * Detach category from an ingredient.
     *
     * @param int|\Reivaj86\ChefAuth\Models\Category $category
     * @return int
     */
    public function detachCategory($category)
    {
        return $this->ingredientCategories()->detach($category);
    }

    /**
     * Detach all categories from an ingredient.
     *
     * @return int
     */
    public function detachAllCategories()
    {
        return $this->ingredientCategories()->detach();
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
