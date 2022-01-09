<?php

namespace App\Model;

use App\Container\Container;

/**
 * Model
 */
abstract class AbtractModel
{
    /**
     * __construct
     *
     * @param mixed $container - 
     * 
     * @return void
     */
    public function __construct(protected Container $container)
    {
    }

    /**
     * __get
     *
     * @param mixed $property - 
     * 
     * @return void
     */
    public function __get($property)
    {
        if ($this->container->get($property)) {
            return $this->container->get($property);
        }
    }
}
