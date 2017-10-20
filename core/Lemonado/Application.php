<?php

namespace Lemonado;

/**
 * Class Application
 *
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado
 */
final class Application
{
    /**
     * @var array
     */
    private $config;

    private $container;

    /**
     * Application constructor.
     *
     * @param array $config Config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }


}