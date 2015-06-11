<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) Reivaj86 <reivaj86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth\Transformers;

use Illuminate\Http\Request;
use Reivaj86\ChefAuth\Exceptions\InvalidArgumentException;

/**
 * This is the transformer kitchen class.
 *
 * @author Reivaj86 <reivaj_86@hotmail.com>
 */
class TransformerKitchen
{
    /**
     * Make a new transformer instance.
     *
     * @param mixed $cookList
     *
     * @throws \InvalidArgumentException
     *
     * @return \Reivaj86\ChefAuth\Transformers\TransformerInterface
     */
    public function make($cookList)
    {
        if (is_object($cookList) && $cookList instanceof Request) {
            return new RequestTransformer();
        }

        if (is_array($cookList)) {
            return new ArrayTransformer();
        }

        throw new InvalidArgumentException('An array, or an instance of Illuminate\Http\Request was expected.');
    }
}