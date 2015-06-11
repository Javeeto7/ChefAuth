<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) Reivaj86 <reivaj_86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the cooker facade class.
 *
 * @author Reivaj86 <reivaj_86@hotmail.com>
 */
class Cooker extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cooker';
    }
}