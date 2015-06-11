<?php
namespace Reivaj86\ChefAuth\Contracts;



interface ChefAuthContract
{
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
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __callChef($method, $parameters);
}