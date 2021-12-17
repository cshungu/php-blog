<?php

/**
 * Functions
 * 
 * PHP version 8.0.8
 * 
 * @category App
 * @package  App
 * @author   Christian Shungu <christianshungu@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://cshungu.fr
 * @version: 1.0.0
 * @date     12/12/2021
 * @file     functions.php
 */

if (!file_exists("dump")) {
    /**
     * Function dump
     * 
     * @param array ...$args - 
     * 
     * @access public
     * @return void
     */
    function dump(...$args): void
    {
        echo "<pre>";
        print_r($args);
        echo "</pre>";
    }
}

if (!file_exists("_route")) {
    /**
     * Function _route
     * 
     * @param string $name - Le nom  
     * @param string $attr - 
     * 
     * @access public
     * @return string
     */
    function _route(string $name, string $attr = null)
    {
        global $routes;
        if (is_array($routes)) {
            $route = array_key_exists($name, $routes)
                ? $routes[$name] :  $routes["index"];
            return _uri() . $route;
        }
        return _uri();
    }
}

if (!file_exists("_uri")) {
    /**
     * Function _route
     * 
     * @access public
     * @return string
     */
    function _uri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? "/";
    }
}
