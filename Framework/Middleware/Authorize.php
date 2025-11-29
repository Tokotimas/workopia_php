<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize
{
    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Session::has(key: 'user');
    }

    /**
     * Handle the user's request
     * 
     * @param string $role
     * @return bool
     */
    public function handle($role): bool
    {
        if ($role === 'guest' && $this->isAuthenticated()) {
            redirect(url: '/');
            return false;
        } elseif ($role === 'auth' && !$this->isAuthenticated()) {
            redirect(url: '/auth/login');
            return false;
        }
        return true;

    }
}