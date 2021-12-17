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
 * @file     authForm.php
 */
define("__APP__", dirname(__DIR__));
require_once join(DIRECTORY_SEPARATOR, [__APP__, "bootstrap", "app.php"]);


$currentUser =  $c->get('security')->isLoggeding();

if (!$currentUser) {
    header('Location: /');
}

const ERROR_REQUIRED = "Veuillez renseigner ce champ";
const ERROR_TITLE_TOO_SHORT = "Le titre est trop court";
const ERROR_CONTENT_TOO_SHORT = "L'article est trop court";
const ERROR_IMAGE_URL = "L'image doit être une url validé";

$errors = [
    "title" => "",
    "image" => "",
    "category" => "",
    "content"  => ""
];
$category = "";

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id   = $_GET['id'] ?? '';

if ($id) {
    $article =  $c->get('article')->fetchOne($id);

    if (!$article['author'] !== $currentUser['id']) {
        //header('Location: /');
    }

    $title    = $article["title"];
    $image    = $article["image"];
    $category = $article["category"];
    $content  = $article["content"];
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $_POST = filter_input_array(
        INPUT_POST,
        [
            "title" => FILTER_SANITIZE_STRING,
            "image" => FILTER_SANITIZE_URL,
            "category" =>  FILTER_SANITIZE_STRING,
            "content"  => [
                "filter" => FILTER_SANITIZE_STRING,
                "flags"  => FILTER_FLAG_NO_ENCODE_QUOTES
            ]
        ]
    );
    $title    = $_POST["title"] ?? "";
    $image    = $_POST["image"] ?? "";
    $category = $_POST["category"] ?? "";
    $content  = $_POST["content"] ?? "";

    if (!$title) {
        $errors['title'] = ERROR_REQUIRED;
    } elseif (mb_strlen($title) < 5) {
        $errors['title'] = ERROR_TITLE_TOO_SHORT;
    }

    if (!$image) {
        $errors['image'] = ERROR_REQUIRED;
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = ERROR_IMAGE_URL;
    }

    if (!$category) {
        $errors['category'] = ERROR_REQUIRED;
    }

    if (!$content) {
        $errors['content'] = ERROR_REQUIRED;
    } elseif (mb_strlen($content) < 50) {
        $errors['content'] = ERROR_CONTENT_TOO_SHORT;
    }
    if (empty(array_filter($errors, fn ($e) => $e !== ""))) {
        if ($id) {
            $article["title"] = $title;
            $article["image"] = $image;
            $article["category"] = $category;
            $article["content"] = $content;
            $article["author"] = $currentUser["id"];
            $c->get('article')->updateOne($article);
        } else {
            $c->get('article')->createOne(
                [
                    "title" => $title,
                    "image" => $image,
                    "category" => $category,
                    "content"  => $content,
                    'author'   => $currentUser["id"]
                ]
            );
        }
        header("Location: /");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/head.php" ?>
    <!-- <link rel="stylesheet" href="public/css/add-article.css"> -->
    <title>
        <?php echo $id ? "Modifier" : "Créer" ?> un article
    </title>
</head>

<body>
    <div class="container">
        <?php require_once "includes/header.php" ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h2><?php echo $id ? "Modifier" : "Ecrire" ?> un article </h2>
                <form action="/articleForm.php<?php echo $id ? "?id=$id" : '' ?>" method="POST">
                    <div class="form-control">
                        <label for="title">Titre</label>
                        <input type="text" name="title" value="<?php echo $title ?? '' ?>">
                        <?php if ($errors["title"]) : ?>
                            <p class="text-danger"><?php echo $errors["title"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="image">Image</label>
                        <input type="text" name="image" value="<?php echo $image ?? '' ?>">
                        <?php if ($errors["image"]) : ?>
                            <p class="text-danger"><?php echo $errors["image"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="category">Catégorie</label>
                        <select name="category" id="category">
                            <option <?php echo !$category || $category === 'technologie' ? 'selected' : '' ?> value="technologie">
                                Technologie
                            </option>
                            <option <?php echo !$category || $category === 'nature' ? 'selected' : '' ?> value="nature">
                                Nature
                            </option>
                            <option <?php echo !$category || $category === 'politique' ? 'selected' : '' ?> value="politique">
                                Politique
                            </option>
                        </select>
                        <?php if ($errors["category"]) : ?>
                            <p class="text-danger"><?php echo $errors["category"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="content">Contenu</label>
                        <textarea name="content"><?php echo $content ?? '' ?></textarea>
                        <?php if ($errors["content"]) : ?>
                            <p class="text-danger"><?php echo $errors["content"] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-secondary" type="button">Annuler</button>
                        <button class="btn btn-primary" type="submit">
                            <?php echo $id ? "Modifier" : "Sauvegarder" ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once "includes/footer.php" ?>
    </div>
</body>

</html>