<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class UserModel extends AbstractModel {

    const ROLE_USER ='USER';
    const ROLE_ADMIN ='ADMIN';



    public function insertUser(string $password,string $pseudo,string $email )
    {
        $sql = 'INSERT INTO users (passwordUser,pseudoUser,emailUser, createdAt)
                VALUES (?,?,?,NOW())';

        return $this->database->insert($sql, [$password,$pseudo,$email]);
    }
    public function updateUser(int $idPicture,int $idUser)
    {
        $sql = 'UPDATE users
                SET idPicture = ?
                WHERE idUser=?';

        return $this->database->insert($sql, [$idPicture,$idUser]);
    }

    public function getUserByEmail(string $email)
    {
        $sql = 'SELECT *
                FROM users
                WHERE emailUser = ?';

        return $this->database->getOneResult($sql, [$email]);
    }
    public function getUserByPseudo(string $pseudo)
    {
        $sql = 'SELECT *
                FROM users
                WHERE pseudoUser = ?';

        return $this->database->getOneResult($sql, [$pseudo]);
    }

    public function checkCredentials(string $email, string $password)
    {
        // On va chercher dans la base l'utilisateur qui correspond à l'email
        $user = $this->getUserByEmail($email);
        var_dump($user);
        // Si on ne trouve aucun utilisateur avec cet email => échec
        if (!$user) {
            return false;
        }

        // Ensuite si le mot de passe est inccorrect => échec
        if (!password_verify($password, $user['passwordUser'])) {
            return false;
        }

        // Si tout est ok, on retourne l'utilisateur
        return $user;
    }

   
    public function addRole(int $userId, string $role)
    {
        $sql = 'INSERT INTO users_role (idUser, idRole) 
                VALUES (?, (SELECT idRole FROM roles WHERE roleLabel = ?))';

        return $this->database->insert($sql, [$userId, $role]);
    }
    
    public function getRoles(int $userId)
    {
        $sql = 'SELECT roleLabel
                FROM roles AS R
                INNER JOIN users_role AS UR ON UR.idRole = R.idRole
                WHERE UR.idUser = ?';

        $roles = $this->database->getAllResults($sql, [$userId]);

            return array_map(function($item){
            return $item['roleLabel'];
        }, $roles);
    }
    public function getPictures($idUser){
        $sql = 'SELECT idPicture
                FROM users
                WHERE idUser = ?';

        return $this->database->getAllResults($sql, [$idUser]);

    }

    //foreach ($roles as $key =>$item){
        //$roles  [$key] = $item['role_label'];
    //}

}