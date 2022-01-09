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

$v = $c->get('validation');
if ($v->method()) {
    $v->validation(
        [
            "email" => function () use ($v) {
                $v->isEmpty()->isEmail()->hasEmail()->get();
            },
            "password" => function () use ($v) {
                $v->isEmpty()->hasPassword()->get();
            },
        ]
    );
    if ($v->failed()) {
        $errors = $v->errors();
    } else {
        $resultats = $v->resultats();
        $email     = $resultats['email'] ?? '';
        $password  = $resultats['password'] ?? '';
        $user = $c->get('security')
            ->getUserFromEmail($email);
        $c->get('security')->login($user['id']);
        header('Location: /');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/head.php" ?>
    <link rel="stylesheet" href="css/auth.login.css">
    <title>Connexion</title>
</head>

<body>
    <div class="container">
        <?php require_once "./includes/header.php" ?>
        <main>
            <div class="content">
                <div class="block p-20 form-container">
                    <h2> Connexion </h2>
                    <form action="/authLogin.php" method="POST">
                        <div class="form-control">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value="<?php echo $email ?? '' ?>">
                            <?php if (isset($errors["email"])) : ?>
                                <p class="text-danger"><?php echo $errors["email"] ?? "" ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-control">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password">
                            <?php if (isset($errors["password"])) : ?>
                                <p class="text-danger"><?php echo $errors["password"] ?? "" ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-secondary" type="button">Annuler</button>
                            <button class="btn btn-primary" type="submit">Connexion</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>