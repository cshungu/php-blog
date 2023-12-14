<?php

namespace App\Security;

/**
 * Class Auth
 * 
 * PHP version 8.0.0
 * 
 * @category App\Security\Auth
 * @package  App\Security\Auth
 * @author   Christian Shungu <christianshungu@gmail.com>
 * @license  https://opensource.org/ MIT
 * @link     https://cshungu.fr
 */
class Auth
{
    /**
     * Method user
     * 
     * @return User
     */
    public function user()
    {
        // if (isset($_SESSION['user'])) {
        //     return Users::find($_SESSION['user']);
        // }
    }
    /**
     * Method check
     * 
     * @return mixed 
     */
    public function check()
    {
        return isset($_SESSION['user']);
    }
    /**
     * Method attempt
     * 
     * @param string|null $email    - Adresse mail
     * @param string|null $password - Mot de passe
     * 
     * @return boolean
     */
    public function attempt($email, $password)
    {
        // $user = Users::where('email', $email)
        //     ->orWhere('login', '=', $email)->first();
        // if (!$user) {
        //     return false;
        // }
        // if (password_verify($password, $user->password)) {
        //     $_SESSION['user'] = $user->id;
        //     return true;
        // }
        // return false;
    }
    /**
     * Method Deconnecter
     * 
     * @return mixed
     */
    public function deconnecter()
    {
        $_SESSION = [];
        session_destroy();
        unset($_SESSION);
    }
    /**
     * Method isExist
     * 
     * @param string|null $email - Adresse mail
     *
     * @return boolean
     */
    public function isExist($email)
    {
        // // $user = Users::where(
        // //     'email',
        // //     $email
        // // )->first(); 
        // if (!$user) {
        //     return false;
        // }
        return true;
    }
}
