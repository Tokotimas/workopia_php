<?php

namespace Framework;

class Session
{
    /**
     * Start the session
     * 
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     * Set a session key/value pair
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    /**
     * Get a session value by the key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null): mixed
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    /**
     * Check if session key exists
     * 
     * @param string $key
     * @return bool
     */
    public static function has($key): bool
    {
        return isset($_SESSION[$key]);
    }
    /**
     * Clear session by key
     * 
     * @param string $key
     * @return void
     */
    public static function clear($key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    /**
     * Clear all session data
     * 
     * @return void
     */
    public static function clearAll(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     * Set a flash message
     * 
     * @param string $key
     * @param string $message
     * @return void
     */
    public static function setFlashMessage($key, $message): void
    {
        self::set(key: 'flash_' . $key, value: $message);
    }

    /**
     * Get a flash message and unset
     * 
     * @param string $key
     * @param mixed $default
     * @return string
     */
    public static function getFlashMessage($key, $default = null): ?string
    {
        $message = self::get(key: 'flash_' . $key, default: $default);
        self::clear(key: 'flash_' . $key);
        return $message;
    }
}