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
 * @file     profil.php
 */
define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);
$currentUser = $c->get('security')->isLoggeding();

if (!$currentUser) {
    header('Location: /');
}

$articles = $c->get('article')->fetchUserArticle($currentUser['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/head.php" ?>
    <link rel="stylesheet" href="css/profil.css">
    <title>Mon profil</title>
</head>

<body>
    <div class="container">
        <?php require_once "includes/header.php" ?>
        <div class="content">
            <h1>Mon espace</h1>
            <h2>Mes informations</h2>
            <div class="info-container">
                <ul>
                    <li>
                        <strong>Prénom :</strong>
                        <p><?php echo $currentUser['firstname'] ?></p>
                    </li>
                    <li>
                        <strong>Nom :</strong>
                        <p><?php echo $currentUser['lastname'] ?></p>
                    </li>
                    <li>
                        <strong>Email :</strong>
                        <p><?php echo $currentUser['email'] ?></p>
                    </li>
                </ul>
            </div>
            <h3>Mes articles</h3>
            <div class="article-list">
                <ul>
                    <?php foreach ($articles as $a) : ?>
                        <li>
                            <span><?php echo $a['title'] ?></span>
                            <div class="article-actions">
                                <a href="/articleForm.php?id=<?php echo $a['id'] ?>" class="btn btn-primary btn-small">Modifier</a>
                                <a href="/articleDelete.php?id=<?php echo $a['id'] ?>" class="btn btn-secondary btn-small">Supprimer</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>