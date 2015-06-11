<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) ChefAuth <reivaj_86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth\Transformers;

use Reivaj86\ChefAuth\CookList;
use Reivaj86\ChefAuth\Exceptions\InvalidArgumentException;

/**
 * This is the array transformer class.
 *
 * @author Reivaj86 <reivaj_86@hotmial.com>
 */
class ArrayTransformer implements TransformerInterface
{
    /**
     * Transform the data into a new data instance.
     *
     * @param array $cookList
     * @param int   $limit
     * @param int   $time
     * @param int   $attempt
     *
     * @throws \InvalidArgumentException
     *
     * @return \Reivaj86\ChefAuth\CookList
     */
    public function transform($cookList, $limit = 10, $time = 60, $attempt = 5)
    {
        if (($recipe = array_get($cookList, 'recipe')) && ($ingredient_list = array_get($cookList, 'ingredient_list'))) {
            return new Cooklist((string) $recipe, (array) $ingredient_list, (int) $limit, (int) $time, (int) $attempt);
        }

        throw new InvalidArgumentException('The data array does not provide the required ip and route information.');
    }
}
