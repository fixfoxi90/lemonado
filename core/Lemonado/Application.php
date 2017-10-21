<?php

namespace Lemonado;

use Lemonado\Server\Dispatcher;
use Lemonado\Server\Request;
use Lemonado\Server\Router;
use Lemonado\Services\Config\ConfigService;
use Lemonado\Services\Manager;
use Lemonado\Session\Session;

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
        // TODO see: https://stackoverflow.com/questions/11700603/what-is-the-difference-between-url-router-and-dispatcher
        $request = new Request();
        $session = new Session();

        $router = new Router($this->getRouting());
        $dispatcher = new Dispatcher();

        $dispatcher->handle($request, $session);
    }

    /**
     * Get Config
     *
     * @return array
     */
    public function getConfig() {
        return $this->service_manager->get(Manager::CONFIG_SERIVCE);
    }

    public function getRouting() {

    }

}