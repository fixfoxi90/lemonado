<?php

namespace Lemonado\Services;

use Lemonado\Exceptions\UnkownConfigException;
use Lemonado\Exceptions\UnkownServiceException;
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

    /**
     * @var
     */
    private $services;

    /**
     * Manager constructor.
     *
     * @param array $service_config Service config array
     * @throws UnkownConfigException Invalid service config given
     */
    public function __construct(array $service_config)
    {

        foreach ($service_config as $type => $services) {

            if (!in_array($type, [self::TYPE_ALIAS, self::TYPE_DYNAMIC, self::TYPE_STATIC])) {
                throw new UnkownConfigException('Unkown config type ' . $type);
            }

            if (!is_array($services)) {
                throw new UnkownConfigException('Services must be type of array');
            }

            foreach ($services as $key => $service) {

                if (!is_callable($services) || !is_string($service)) {
                    throw new UnkownConfigException('Service ' . (string)$service . ' must be callable class string');
                }

                if (isset($this->services[$key])) {
                    throw new UnkownConfigException('Dupplicated service key ' . $key);
                }

                if ($type === self::TYPE_STATIC) {
                    $service = $service();
                }

                $this->services[$key] = [
                    'type' => $type,
                    'class' => $service
                ];

            }

        }

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

        if (isset($this->services[$key])) {
            throw new UnkownConfigException('Dupplicated service key ' . $key);
        }

        if (!is_callable($service) || !is_string($service)) {
            throw new UnkownConfigException('Service ' . (string)$service . ' must be callable class string');
        }

        if (!in_array($type, [self::TYPE_ALIAS, self::TYPE_DYNAMIC, self::TYPE_STATIC])) {
            throw new UnkownConfigException('Unkown config type ' . $type);
        }

        if ($type === self::TYPE_STATIC) {
            $service = $service();
        }

        $this->services[$key] = [
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

        $service = $this->services[$id];

        $service_type = $service['type'];
        $service_class = $service['class'];

        switch($service_type) {

            case self::TYPE_ALIAS:
                return $this->get($service_class);

            case self::TYPE_DYNAMIC:
                return $service_class();

            case self::TYPE_STATIC:

                if (!is_object($service_class)) {
                    throw new UnkownServiceException('Invalid serivce type');
                }

                return $service_class;

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
        return isset($services[$id]);
    }
}