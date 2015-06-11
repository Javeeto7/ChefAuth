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

use Reivaj86\ChefAuth\Kitchen\CookInterface;
use Reivaj86\ChefAuth\Transformers\TransformerKitchen;

/**
 * This is the Cooker class.
 *
 * @author Reivaj86 <reivaj_86@hotmail.com>
 */
class Cooker
{
    /**
     * The cached cooker instances.
     *
     * @var \Reivaj86\ChefAuth\Cookers\CookerInterface[]
     */
    protected $cookers = [];

    /**
     * The factory instance.
     *
     * @var \Reivaj86\ChefAuth\Factories\FactoryInterface
     */
    protected $factory;

    /**
     * The factory instance.
     *
     * @var \Reivaj86\ChefAuth\Transformers\TransformerFactory
     */
    protected $transformer;

    /**
     * Create a new instance.
     *
     * @param \Reivaj86\ChefAuth\Factories\FactoryInterface      $factory
     * @param \Reivaj86\ChefAuth\Transformers\TransformerFactory $transformer
     *
     * @return void
     */
    public function __construct(FactoryInterface $factory, TransformerFactory $transformer)
    {
        $this->factory = $factory;
        $this->transformer = $transformer;
    }

    /**
     * Get a new cooker.
     *
     * @param array|\Illuminate\Http\Request $data
     * @param int                            $limit
     * @param int                            $time
     *
     * @return \Reivaj86\ChefAuth\Cookers\CookerInterface
     */
    public function get($data, $limit = 10, $time = 60)
    {
        $transformed = $this->transformer->make($data)->transform($data, $limit, $time);
        //dd($transformed);
        if (!array_key_exists($key = $transformed->getKey(), $this->cookers)) {
            $this->cookers[$key] = $this->factory->make($transformed);
        }

        return $this->cookers[$key];
    }

    /**
     * Get the cache instance.
     *
     * @return \Reivaj86\ChefAuth\Factories\FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Get the transformer instance.
     *
     * @codeCoverageIgnore
     *
     * @return \Reivaj86\ChefAuth\Transformers\TransformerFactory
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Dynamically pass methods to a new cooker instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, 'get'], $parameters)->$method();
    }
}
