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
 * @file     authLogin.php
 */
define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);
$currentUser = $c->get('security')->isLoggeding();

if ($currentUser) {
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id   = $_GET['id'] ?? '';

    if ($id) {
        $article =  $c->get('article')->fetchOne($id);
        if ($article['author'] === $currentUser['id']) {
        }
        $c->get('article')->deleteOne($id);
        header("Location: /");
    }
}
header("Location: /");
