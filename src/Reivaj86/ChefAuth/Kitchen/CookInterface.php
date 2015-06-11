<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) Reivaj86 <reivaj86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth\Factories;

use Reivaj86\ChefAuth\CookList;

/**
 * This is the ChefAuth cook interface.
 *
 * @author Reivaj86 <reivaj86@hotmail.com>
 */
interface CookInterface
{
    /**
     * Make a new cook instance.
     *
     * @param \Reivaj86\ChefAuth\CookList $cookList
     *
     * @return \Reivaj86\ChefAuth\Cookers\CookersInterface
     */
    public function cook(CookList $cookList);
}
