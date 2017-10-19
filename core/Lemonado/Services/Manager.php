<?php

namespace Lemonado\Services;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class Manager
 *
 * @author Felix Steidler <info@felix-steidler.de>
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
     */
    public function __construct(array $service_config)
    {

        foreach ($service_config as $type => $services) {

            if (!in_array($type))

        }

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
        // TODO: Implement get() method.
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
        return isset($services);
    }
}