<?php 

namespace App\Framework;


class UserSession {

    static private function sessionCheck(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Enregistre les informations de l'utilisateur en session
     */
    static function register(int $userId, string $firstname, string $lastname, string $email, array $roles)
    {
        self::sessionCheck();

        // Enregistrement des données de l'utilisateur en session à la clé 'user'
        $_SESSION['user'] = [
            'userId' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'roles' => $roles
        ];
    }

    static function isAuthenticated()
    {
        self::sessionCheck();
        return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
    }

    static function logout()
    {
        if (!self::isAuthenticated()){
            return;
        }
        $_SESSION['user'] = null;
        session_destroy();
    }

    static function getId()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['userId'];
    }

    static function getFirstname()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['firstname'];
    }

    static function getLastname()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['lastname'];
    }

    static function getEmail()
    {
        if (!self::isAuthenticated()){
            return null;
        }
        return $_SESSION['user']['email'];
    }

    static function hasRoles(){
        if(!self::isAuthenticated()){
            return false;
        }
        // $args = func_get_args();
        // var_dump($_SESSION);
        // for($i=0; $i < count($args) ; $i++) { 
        //     foreach ($_SESSION['user']["roles"] as $key => $roles) {
        //         if($args[$i] == $roles){
        //         return true;
        //         }
        //     }
            
        // }
        // return false;
        return array_intersect(func_get_args(),$_SESSION['user']['roles']);



    }

       
        
}