<?php

namespace Lemonado\Server;

use Lemonado\Session\Session;

/**
 * Class Dispatcher
 *
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado\Server
 */
class Dispatcher
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Handle dispatcher
     *
     * @param Request $request Request
     * @param Session $session Session
     */
    public function handle(Request $request, Session $session) {

    }
}