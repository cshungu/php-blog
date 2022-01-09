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
 * @file     index.php
 */

use App\Database\Db;

define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);

$currentUser = $c->get('security')->isLoggeding();
$articles = $c->get('article')->fetchAll();
$categories = [];
$users = $c->get("user")
    ->getAll();
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
                $acc[$article['category']] = [
                    ...$acc[$article['category']],
                    $article
                ];
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
    <?php require_once "./includes/head.php" ?>
    <link rel="stylesheet" href="css/index.css">
    <title>Blog</title>
</head>

<body>
    <div class="container">
        <?php require_once "./includes/header.php" ?>
        <main>
            <div class="content">
                <div class="newsfeed-container">
                    <ul class="category-container">
                        <li class=<?php echo $selectedCat ? '' : 'cat-active' ?>>
                            <a href="/">Tous les articles
                                <span class="small">(<?php echo count($articles) ?>)</span>
                            </a>
                        </li>
                        <?php foreach ($categories as $catName => $catNum) : ?>

                            <li class=<?php echo $selectedCat === $catName ? 'cat-active' : '' ?>>
                                <a href="/?cat=<?php echo $catName ?>">
                                    <?php echo $catName ?><span class="small">(<?php echo $catNum ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="newsfeed-content">
                        <?php if (!$selectedCat) : ?>
                            <?php foreach ($categories as $cat => $num) : ?>
                                <h2><?php echo ucfirst($cat) ?></h2>
                                <div class="articles-container">
                                    <?php foreach ($articleParCategories[$cat] as $a) : ?>
                                        <a href="/articleShow.php?id=<?php echo $a['id'] ?>" class="article block">
                                            <div class="overflow">
                                                <div class="img-container" style="background-image:url(<?php echo $a['image'] ?>)">
                                                </div>
                                            </div>
                                            <h3><?php echo substr($a["title"], 0,  25) ?></h3>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else :  ?>
                            <h2><?php echo ucfirst($selectedCat) ?></h2>
                            <div class="articles-container">
                                <?php foreach ($articleParCategories[$selectedCat] as $a) : ?>
                                    <a href="/articleShow.php?id=<?php echo $a['id'] ?>" class="article block">
                                        <div class="overflow">
                                            <div class="img-container" style="background-image:url(<?php echo $a['image'] ?>)">
                                            </div>
                                        </div>
                                        <h3><?php echo substr($a["title"], 0,  25) ?></h3>
                                        <?php if ($a['author']) : ?>
                                            <div class="article-author">
                                                <p><?php echo $a['firstname'] . ' ' . $a['lastname'] ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once "./includes/footer.php" ?>
    </div>
</body>

</html>