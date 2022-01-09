<?php

namespace App\Model;

use App\Container\Container;

class User extends AbtractModel
{
    /**
     * __construct
     *
     * @param mixed $container - 
     * 
     * @return void
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function getAll()
    {
    }
}
