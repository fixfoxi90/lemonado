<?php

namespace Lemonado\Services;

use Lemonado\Exceptions\UnkownConfigException;
use Lemonado\Exceptions\UnkownServiceException;
use Lemonado\Services\Config\ConfigService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class Manager
 *
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado\Services
 */
final class Manager implements ContainerInterface
{

    const TYPE_ALIAS = 'alias';
    const TYPE_DYNAMIC = 'dynamic';
    const TYPE_STATIC = 'static';

    const CONFIG_SERIVCE = 'config';

    /**
     * @var
     */
    private static $services;

    /**
     * Manager constructor.
     *
     * @param ConfigService $configService Config service
     * @throws UnkownConfigException Invalid service config given
     */
    public function __construct(ConfigService $configService)
    {

        $this->setConfigs($configService);

        foreach ($configService->getServices() as $type => $services) {

            if (!in_array($type, [self::TYPE_ALIAS, self::TYPE_DYNAMIC, self::TYPE_STATIC])) {
                throw new UnkownConfigException('Unkown config type ' . $type);
            }

            if (!is_array($services)) {
                throw new UnkownConfigException('Services must be type of array');
            }

            foreach ($services as $key => $service) {

                if (!class_exists($service)) {
                    throw new UnkownConfigException('Cannot find service class ' . $service);
                }

                if (isset(self::$services[$key])) {
                    throw new UnkownConfigException('Dupplicated service key ' . $key);
                }

                $this->appendService($key, $type, $service);

            }

        }

    }

    /**
     * Set configs
     *
     * @param ConfigService $configService ConfigService
     * @return void
     */
    private function setConfigs(ConfigService $configService) {

        self::$services[self::CONFIG_SERIVCE] = [
            'type' => self::TYPE_STATIC,
            'class' => $configService
        ];

    }

    /**
     * Create service class
     *
     * @param string $service Service
     * @return Object
     */
    private function create_service($service) {

        if (is_callable($service)) {
            return $service($this);
        }

        return new $service();

    }

    /**
     * Append service to manager
     *
     * @param string $key Key
     * @param string $service Service
     * @param string $type Type
     * @throws UnkownConfigException Invalid service data
     */
    public function append($key, $service, $type) {

        if (isset(self::$services[$key])) {
            throw new UnkownConfigException('Dupplicated service key ' . $key);
        }

        if (!class_exists($service)) {
            throw new UnkownConfigException('Cannot find service class ' . $service);
        }

        if (!in_array($type, [self::TYPE_ALIAS, self::TYPE_DYNAMIC, self::TYPE_STATIC])) {
            throw new UnkownConfigException('Unkown config type ' . $type);
        }

        $this->appendService($key, $type, $service);

    }

    /**
     * Append service
     *
     * @param string $key Key
     * @param string $type Type of service
     * @param string $service Service
     */
    private function appendService($key, $type, $service) {

        self::$services[$key] = [
            'type' => $type,
            'class' => $service
        ];

    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {

        if (!$this->has($id)) {
            throw new UnkownServiceException('Unkown service ' . $id);
        }

        $service = self::$services[$id];

        $service_type = $service['type'];
        $service_class = $service['class'];

        switch($service_type) {

            case self::TYPE_ALIAS:
                return $this->get($service_class);

            case self::TYPE_DYNAMIC:
                return $this->create_service($service_class);

            case self::TYPE_STATIC:

                if (is_object($service_class)) {
                    return $service_class;
                }

                return self::$services[$id]['class'] = $this->create_service($service_class);
            
        }

        throw new UnkownServiceException('Unkown service ' . $id);

    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return isset(self::$services[$id]);
    }
}