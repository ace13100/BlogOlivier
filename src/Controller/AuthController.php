<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\UserModel;
use App\Framework\UserSession;
use App\Framework\FlashBag;

class AuthController extends AbstractController {

    public function login()
    {
        if (!empty($_POST)) {

            // On récupère les données du formulaire de connexion, email et password
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            // On crée un objet UserModel pour appeler la méthode checkCredentials() qui va vérifier les identifiants
            $userModel = new UserModel();
            $user = $userModel->checkCredentials($email, $password);
            
            
            
            
           
            // Aucun utilisateur n'a été trouvé avec ces identifiants
            if (!$user) {
                FlashBag::addFlash('Identifiants incorrects', 'error');
            }
            // On a bien récupéré l'utilisateur, les identifiants sont corrects
            else {
                
                $roles = $userModel->getRoles($user['idUser']);
                // Enregistre le user en session
                UserSession::register($user['idUser'], $user['pseudoUser'],$user['emailUser'],$roles);
        
                // Message flash de succès
                FlashBag::addFlash('Connexion réussie');
        
                // Redirection
                $this->redirect('homepage');
            }
        }
        
        // Affichage
        return $this->render('login');
    }

    public function logout()
    {
        // Déconnexion
        UserSession::logout();

        // Redirection vers l'accueil
        $this->redirect('homepage');
    }
}