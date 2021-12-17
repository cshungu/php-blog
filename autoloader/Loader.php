<?php

/**
 * Loader
 * 
 * PHP 8.0.8
 * 
 * @category App
 * @package  App
 * @author   Christian Shungu <christianshungu@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://cshungu.fr
 * @version: 1
 * @date     12/12/2022
 * @file     Loader.php
 */
class Loader
{
    /**
     * Methode register
     * 
     * @return void
     */
    public static function register(): void
    {
        spl_autoload_register(
            [__CLASS__, '_autoloader']
        );
    }
    /**
     * Methode autoloader
     * 
     * @param string $className - 
     * 
     * @return void
     */
    private static function _autoloader(string $className): void
    {
        $class  = str_replace('App\\', '', $className);
        $class  = str_replace('\\', '/', $class);
        $class  = str_replace('/', '\\', $class);
        $path   = __APP__ . DIRECTORY_SEPARATOR;
        $path  .= "src" . DIRECTORY_SEPARATOR;
        $filename = $path . $class . ".php";
        if (file_exists($filename) && is_readable($filename)) {
            include_once $filename;
        }
    }
}
