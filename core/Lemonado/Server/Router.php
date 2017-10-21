<?php

namespace Lemonado\Server;

/**
 * Class Router
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado\Server
 */
class Router
{

    /**
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     *
     * @param array $routes Routing
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

}