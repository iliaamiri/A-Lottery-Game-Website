<?php
/**
 * Created by PhpStorm.
 * User: pcs
 * Date: 30/03/2018
 * Time: 03:52 PM
 */

namespace Model;


class session
{
    function __construct($limit = 0, $path = '/')
    {
        session_name("__gsr");
        session_set_cookie_params($limit, $path, $_SERVER['SERVER_NAME'],false, true);
        session_start();
    }
}