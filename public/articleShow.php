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
 * @file     articleForm.php
 */
define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);
$currentUser =  $c->get('security')->isLoggeding();
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id   = $_GET['id'] ?? '';

if (!$id) {
    header("Location: /");
} else {
    $article = $c->get('article')->fetchOne($id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/head.php" ?>
    <link rel="stylesheet" href="css/article.show.css">
    <title>Créer un article</title>
</head>

<body>
    <div class="container">
        <?php require_once "includes/header.php" ?>
        <main>
            <div class="content">
                <div class="article-container">
                    <a class="article-back" href="/">Retour à l'article</a>
                    <div class="article-cover-img" style="background-image:url(<?php echo $article['image'] ?>)">
                    </div>
                    <h1 class="article-title">
                        <?php echo $article["title"] ?>
                    </h1>
                    <div class="separtor"></div>
                    <p class="article-content">
                        <?php echo $article["content"] ?>
                    </p>
                    <p class="article-author"><?php echo $article['firstname'] . ' ' . $article['lastname'] ?></p>
                    <?php if ($currentUser && $currentUser['id'] ===  $article['author']) : ?>
                        <div class="action">
                            <a class="btn btn-secondary" href="/articleDelete.php?id=<?php echo $article['id'] ?>">Supprimer</a>
                            <a class="btn btn-primary" href="/articleForm.php?id=<?php echo $article['id'] ?>">
                                Editer l'article
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>