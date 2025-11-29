<?php

namespace Framework;

use Framework\Session;

class Authorization
{
    /**
     * Check if current logged in user iwns a resource
     * 
     * @param int $resourceId
     * @return bool
     */
    public static function isOwner($resourceId): bool
    {
        $sessionUser = Session::get(key: 'user');

        if ($sessionUser !== null && isset($sessionUser['id'])) {
            $sessionUserId = (int) $sessionUser['id'];
            return $sessionUserId === $resourceId;
        }

        return false;
    }
}