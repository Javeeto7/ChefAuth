<?php

/*
 * This file is part of ChefAuth.
 *
 * (c) Reivaj86 <reivaj_86@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Reivaj86\ChefAuth\Cookers;

/**
 * This is the cooker interface class.
 *
 * @author Reivaj86 <reivaj_86@hotmail.com>
 */
interface CookerInterface
{
    /**
     * Rate limit access to a cooker.
     *
     * @return bool
     */
    public function attempt();

    /**
     * Hire the cooker.
     *
     * @return $this
     */
    public function hire();

    /**
     * Clean the cooker.
     *
     * @return $this
     */
    public function clean();

    /**
     * Get the cooker hire count.
     *
     * @return int
     */
    public function count();

    /**
     * Check the cooker.
     *
     * @return bool
     */
    public function check();
}
