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


const ERROR_REQUIRED = "Veuillez renseigner ce champ";
const ERROR_PASSWORD_TOO_SHORT = "Le mot de passe doit faire au moins 6 caractères";
const ERROR_PASSWORD_MISMATCH = "Le mot de passe n'est pas valide";
const ERROR_EMAIL_INVALID = "L'email n'est pas valide";
const ERROR_EMAIL_UNKNOWN = "L'email n'est pas enregistrée";


$errors = [
    "email" => "",
    "password"  => "",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $input = filter_input_array(
        INPUT_POST,
        [
            'email' => FILTER_SANITIZE_EMAIL,
        ]
    );
    $email     = $input['email'] ?? '';
    $password  = $_POST['password'] ?? '';


    if (!$email) {
        $errors['email'] = ERROR_REQUIRED;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = ERROR_EMAIL_INVALID;
    }

    if (!$password) {
        $errors['password'] = ERROR_REQUIRED;
    } elseif (mb_strlen($password) < 6) {
        $errors['password'] = ERROR_PASSWORD_TOO_SHORT;
    }


    if (empty(array_filter($errors, fn ($e) => $e !== ""))) {
        $user = $c->get('security')->getUserFromEmail($email);

        if (!$user) {
            $errors['email'] = ERROR_EMAIL_UNKNOWN;
        } else {
            if (!password_verify($password, $user['password'])) {
                $errors['password'] = ERROR_PASSWORD_MISMATCH;
            } else {
                $c->get('security')->login($user['id']);
                header('Location: /');
            }
        }
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
        <div class="content">
            <div class="block p-20 form-container">
                <h2> Connexion </h2>
                <form action="/authLogin.php" method="POST">
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo $email ?? '' ?>">
                        <?php if ($errors["email"]) : ?>
                            <p class="text-danger"><?php echo $errors["email"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password">
                        <?php if ($errors["password"]) : ?>
                            <p class="text-danger"><?php echo $errors["password"] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-secondary" type="button">Annuler</button>
                        <button class="btn btn-primary" type="submit">Connexion</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>