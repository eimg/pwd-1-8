<?php

namespace Helpers;

class Auth
{
    static function check()
    {
        session_start();
        if(!isset($_SESSION['user'])) {
            HTTP::redirect("/index.php", "auth=fail");
        }

        return $_SESSION['user'];
    }
}
