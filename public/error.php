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
 * @file     error.php
 */
define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);
$currentUser = $c->get('security')->isLoggeding();

$articles = $c->get('article')->fetchAll();
$categories = [];
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedCat = $_GET["cat"] ?? "";

if (count($articles)) {
    $cattmp = array_map(fn ($a) => $a['category'], $articles);
    $categories = array_reduce(
        $cattmp,
        function ($acc, $item) {
            if (isset($acc[$item])) {
                $acc[$item]++;
            } else {
                $acc[$item]  = 1;
            }

            return $acc;
        },
        []
    );
    $articleParCategories = array_reduce(
        $articles,
        function ($acc, $article) {
            if (isset($acc[$article['category']])) {
                $acc[$article['category']] = [...$acc[$article['category']], $article];
            } else {
                $acc[$article['category']] = [$article];
            }
            return $acc;
        },
        []
    );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/head.php" ?>
    <link rel="stylesheet" href="css/index.css">
    <title>Blog</title>
</head>

<body>
    <div class="container">
        <?php require_once "includes/header.php" ?>
        <main>
            <div class="content">
                <h1 class="font-size: 7rem; text-align: center">Oops une erreur esr</h1>
            </div>
        </main>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>