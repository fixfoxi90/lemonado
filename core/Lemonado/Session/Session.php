<?php

namespace Lemonado\Session;

/**
 * Class Session
 *
 * @author Felix Steidler
 * @copyright felix-steidler.de
 * @package Lemonado\Session
 */
class Session
{

    /**
     * Session constructor.
     */
    public function __construct(\SessionHandlerInterface $sessionHandler = null)
    {

        if ($sessionHandler !== null) {
            session_set_save_handler($sessionHandler);
        }

        if ($this->getStatus() == PHP_SESSION_NONE) {
            session_start();
        }

    }

    public function set($key, $value) {

    }

    public function get($key) {
        
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId() {
        return session_id();
    }

    /**
     * Set id
     *
     * @param string $id Id
     * @return string
     */
    public function setId($id) {
        return session_id($id);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return session_name();
    }

    /**
     * Set name
     *
     * @param string $name Name
     * @return string
     */
    public function setName($name) {
        return session_name($name);
    }

    /**
     * Get session status
     *
     * @return integer
     */
    public function getStatus() {
        return session_status();
    }

    /**
     * Destroy
     *
     * @return boolean
     */
    public function destroy() {
        return session_destroy();
    }

    /**
     * Reset
     *
     * @return boolean
     */
    public function reset() {
        return session_reset();
    }

    /**
     * Clear
     *
     * @return void
     */
    public function clear() {
        session_unset();
    }

    /**
     * Close
     *
     * @return void
     */
    public function close() {
        session_write_close();
    }
}