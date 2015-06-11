<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) Reivaj86 <reivaj86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth;

/**
 * This is the cookList class.
 *
 * @author Reivaj86 <reivaj86@hotmail.com>
 */
class CookList
{
    /**
     * The attempt
     *
     * @var int
     */
    protected $attempt;

    /**
     * The recipe.
     *
     * @var string
     */
    protected $recipe;

    /**
     * The ingredient list.
     *
     * @var array
     */
    protected $ingredient_list;

    /**
     * The request limit.
     *
     * @var int
     */
    protected $limit;

    /**
     * The expiration time.
     *
     * @var int
     */
    protected $time;

    /**
     * The unique key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new instance.
     *
     * @param int $attempt
     * @param string $recipe
     * @param array $ingredient_list
     * @param int    $limit
     * @param int    $time
     *
     * @return void
     */
    public function __construct($attempt, $recipe, $ingredient_list, $limit = 5, $time = 60)
    {
        $this->attempt = $attempt;
        $this->recipe = $recipe;
        $this->ingredient_list = $ingredient_list;
        $this->limit = $limit;
        $this->time = $time;
    }

    /**
     * Get the attempt.
     *
     * @return string
     */
    public function getAttempt()
    {
        return $this->attempt;
    }

    /**
     * Get the recipe.
     *
     * @return string
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Get the ingredient list.
     *
     * @return Ingredient array
     */
    public function getIngredientList()
    {
        return $this->ingredient_list;
    }

    /**
     * Get the request limit.
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get the expiration time.
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get the unique key.
     *
     * This key is used to identify the data between requests.
     *
     * @var string
     */
    public function getKey()
    {
        if (!$this->key) {
            $this->key = sha1($this->ip.$this->route);
        }

        return $this->key;
    }
}
