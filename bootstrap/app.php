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
 * @file     app.php
 */

use App\Database\Db;
use App\Model\Article;
use App\Model\Security;
use App\Container\Container;

session_start();
$routes = include_once join(DIRECTORY_SEPARATOR, [__APP__, "config", "routes.php"]);
require_once join(DIRECTORY_SEPARATOR, [__APP__, "config", "function.php"]);
require_once join(DIRECTORY_SEPARATOR, [__APP__, "autoloader", "autoload.php"]);

$c = new Container();
$c['db'] = function () {
    return Db::getInstance();
};
$c['article'] = function () use ($c) {
    return new Article($c->get('db'));
};
$c['security'] = function () use ($c) {
    return new Security($c->get('db'));
};
