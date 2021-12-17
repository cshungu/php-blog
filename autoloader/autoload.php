<?php

/**
 * Autoload
 * 
 * PHP version 8.8.8
 * 
 * @category App
 * @package  App
 * @author   Christian Shungu <christianshungu@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/silex100
 * @version: 1
 * @date     12/12/2021
 * @file     autoload.php
 */
require_once join(DIRECTORY_SEPARATOR, [__APP__, 'autoloader', 'Loader.php']);
Loader::register();
