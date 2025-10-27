<?php

namespace Framework;

use Framework\Session;


class UserCheck
{


    public static function isOwner($resourceId)
    {
        $sessionUser = Session::get('user');

        if (isset($sessionUser) && isset($sessionUser['id'])) {
            $sessionUserId = (int) $sessionUser['id'];
            return $sessionUserId === $resourceId;
        }

        return false;
    }
}
