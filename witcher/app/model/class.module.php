<?php
namespace Model;

class module{
    public static $loggedIn_user;
    public static $callback_url;
    public static $preg;
    function __construct()
    {
        $user = new user;
        self::$loggedIn_user = array_merge($user->user_get_certificate(),$user->user_get_permission());
        self::$preg = new preg();
    }
}