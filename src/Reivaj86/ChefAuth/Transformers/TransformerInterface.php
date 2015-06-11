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

/**
 * This is the transformer interface.
 *
 * @author Reivaj86 <reivaj_86@hotmail.com>
 */
interface TransformerInterface
{
    /**
     * Transform the data into a new data instance.
     *
     * @param array|\Illuminate\Http\Request $cookList
     * @param int                            $limit
     * @param int                            $time
     * @param int                            $attempt
     *
     * @return \Reivaj86\ChefAuth\CookList
     */
    public function transform($cookList, $limit = 10, $time = 60, $attempt = 5);
}