<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.10.18
 * Time: 23:40
 */

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}
Autoloader::register();