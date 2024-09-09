<?php
namespace Dkd\PhpCmis\Bindings;

/*
 * This file is part of php-cmis-client.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * CMIS provider session interface.
 */
interface BindingSessionInterface
{
    /**
     * Returns the ID of this session.
     *
     * @return string
     */
    public function getSessionId();

    /**
     * Returns all keys.
     *
     * @return string[]
     */
    public function getKeys();

    /**
     * Gets a session value or the default value if the key doesn't exist.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key, mixed $defaultValue = null);

    /**
     * Adds a session value.
     *
     * @param string $key
     */
    public function put($key, mixed $value);

    /**
     * Removes a session value.
     *
     * @param string $key
     */
    public function remove($key);
}
