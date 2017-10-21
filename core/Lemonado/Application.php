<?php

namespace Lemonado;

use Lemonado\Server\Request;
use Lemonado\Services\Config\ConfigService;
use Lemonado\Services\Manager;

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
     * @var Manager
     */
    private $service_manager;

    /**
     * Application constructor.
     *
     * @param array $config Config
     */
    public function __construct(array $config)
    {
        $this->service_manager = new Manager(new ConfigService($config));
    }

    public function run()
    {
        $request = new Request();
    }

    /**
     * Get Config
     *
     * @return array
     */
    public function getConfig() {
        return $this->service_manager->get(Manager::CONFIG_SERIVCE);
    }

}