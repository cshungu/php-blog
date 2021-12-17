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
const ERROR_TOO_SHORT = "Ce champ est trop court";
const ERROR_PASSWORD_TOO_SHORT = "Le mot de passe doit faire au moins 6 caractères";
const ERROR_PASSWORD_MISMATCH = "Le mot de passe de confirmation est différent";
const ERROR_EMAIL_INVALID = "L'email n'est pas valide";


$errors = [
    "firstname" => "",
    "lastname" => "",
    "email" => "",
    "password"  => "",
    "confirmpassword" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $input = filter_input_array(
        INPUT_POST,
        [
            'firstname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'lastname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
        ]
    );
    $firstname = $input['firstname'] ?? '';
    $lastname  = $input['lastname'] ?? '';
    $email     = $input['email'] ?? '';
    $password  = $_POST['password'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';

    if (!$firstname) {
        $errors['firstname'] = ERROR_REQUIRED;
    } elseif (mb_strlen($firstname) < 3) {
        $errors['firstname'] = ERROR_TOO_SHORT;
    }

    if (!$lastname) {
        $errors['lastname'] = ERROR_REQUIRED;
    } elseif (mb_strlen($lastname) < 3) {
        $errors['lastname'] = ERROR_TOO_SHORT;
    }

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

    if (!$confirmpassword) {
        $errors['confirmpassword'] = ERROR_REQUIRED;
    } elseif ($confirmpassword !== $password) {
        $errors['confirmpassword'] = ERROR_PASSWORD_MISMATCH;
    }

    if (empty(array_filter($errors, fn ($e) => $e !== ""))) {
        $c->get('security')->register(
            [
                'firstname' => $firstname,
                'lastname'  => $lastname,
                'email' => $email,
                'password' => $password,
            ]
        );
        header("Location: /");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/head.php" ?>
    <link rel="stylesheet" href="css/auth.register.css">
    <title>Inscription</title>
</head>

<body>
    <div class="container">
        <?php require_once "includes/header.php" ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h2> Inscription </h2>
                <form action="/authRegister.php" method="POST">
                    <div class="form-control">
                        <label for="title">Prénom</label>
                        <input type="text" name="firstname" id="firstname" value="<?php echo $firstname ?? '' ?>">
                        <?php if ($errors["firstname"]) : ?>
                            <p class="text-danger">
                                <?php echo $errors["firstname"] ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="lastname">Nom</label>
                        <input type="text" name="lastname" id="lastname" value="<?php echo $lastname ?? '' ?>">
                        <?php if ($errors["lastname"]) : ?>
                            <p class="text-danger"><?php echo $errors["lastname"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo $email ?? '' ?>">
                        <?php if ($errors["email"]) : ?>
                            <p class="text-danger">
                                <?php echo $errors["email"] ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password">
                        <?php if ($errors["password"]) : ?>
                            <p class="text-danger"><?php echo $errors["password"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="confirmpassword">
                            Confirmation Mot de passe
                        </label>
                        <input type="password" name="confirmpassword" id="confirmpassword">
                        <?php if ($errors["confirmpassword"]) : ?>
                            <p class="text-danger">
                                <?php echo $errors["confirmpassword"] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-secondary" type="button">
                            Annuler
                        </button>
                        <button class="btn btn-primary" type="submit">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>