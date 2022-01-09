<?php

namespace App\Validation;

/**
 * Class trait Messages
 * 
 * PHP version 8.0.0
 * 
 * @category App\Validation
 * @package  App\Validation
 * @author   Christian Shungu <christianshungu@gmail.com>
 * @license  https://opensource.org/ MIT
 * @link     https://cshungu.fr
 */

trait Messages
{

    /**
     * Variables messages
     *
     * @var array $messages
     */
    protected $messages = [
        "empty"   => "Ce champ {{input}} est vide.",
        "number"  => "Ce champ {{input}} ne correspond à aucun nombre.",
        "size"    => "La taille du champ {{input}} ne correspond pas à la taille requise. ",
        "confirm" => "Les deux {{input}} saisies ne correspondent pas.",
        "invalid" => "Ce champ {{input}} n'est pas validé.",
        "tag"      => "Ce champ {{input}} n'est pas valide, il contient une balise html. ",
        "unknown"  => "Cet {{input}} n'est pas enregistrée.",
        "password" => "Le mot de passe n'est pas valide",
        "short"    => "Ce champ {{input}} est trop court.",
        "long"     => "Ce champ {{input}} est trop long.",
    ];
}
