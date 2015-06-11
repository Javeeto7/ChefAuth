<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) Reivaj86 <reivaj_86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth\Transformers;

use Reivaj86\ChefAuth\CookList;

/**
 * This is the request transformer class.
 *
 * @author Reivaj86 <reivaj_86@hotmail.com>
 */
class RequestTransformer implements TransformerInterface
{
    /**
     * Transform the data into a new data instance.
     *
     * @param \Illuminate\Http\Request $cookList
     * @param int                      $limit
     * @param int                      $time
     *
     * @return \Reivaj86\ChefAuth\CookList
     */
    public function transform($cookList, $limit = 5, $time = 60, $attempt = 5)
    {
        return new CookList((int) $attempt, (string) $cookList->attributes->get('recipe'),(array) $cookList->attributes->get('ingredient_list'), (int) $limit, (int) $time);
    }
}
