<?php

namespace src\middlewares;

use Slim\Container;

/**
 * Class Middleware
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @package src\middlewares
 */
class Middleware {

    /**
     * @var Container
     */
    protected $container;

    /**
     * Controller constructor.
     * @param $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }
}