<?php

namespace Lemonado\Services\Config;

/**
 * Class ConfigService
 *
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado\Services\Config
 */
class ConfigService
{

    const SERVICES = 'services';

    /**
     * @var array
     */
    private $config;

    /**
     * ConfigService constructor.
     *
     * @param array $config Config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get services
     *
     * @return array
     */
    public function getServices() {
        return isset($this->config[self::SERVICES]) ? $this->config[self::SERVICES] : [];
    }
}