<?php

/**
 * App
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
 * @file     authLogout.php
 */
define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);
$sessionId = $_COOKIE['session'];

if ($sessionId) {
    $c->get('security')->logout($sessionId);
    header('Location: /authLogin.php');
}
