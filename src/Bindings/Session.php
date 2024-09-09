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
 * CMIS binding session implementation.
 */
class Session implements BindingSessionInterface
{
    protected string $sessionId;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Creates a new session with a unique session id
     */
    public function __construct()
    {
        $this->sessionId = uniqid('dkd-cmis-binding-session-');
    }

    /**
     * Returns the ID of this session.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Returns all keys.
     *
     * @return string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Gets a session value or the default value if the key doesn't exist.
     *
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        return $this->data[$key] ?? $defaultValue;
    }

    /**
     * Adds a session value.
     *
     * @param string $key
     * @param mixed $value
     */
    public function put($key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Removes a session value.
     *
     * @param string $key
     */
    public function remove($key): void
    {
        unset($this->data[$key]);
    }
}
