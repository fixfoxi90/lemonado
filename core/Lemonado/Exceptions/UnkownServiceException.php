<?php

namespace Lemonado\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class UnkownServiceException
 *
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado\Exceptions
 */
class UnkownServiceException extends LemonadoException implements NotFoundExceptionInterface
{
    // Nothing to do here
}