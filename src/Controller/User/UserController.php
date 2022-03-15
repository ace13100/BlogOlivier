<?php 

namespace App\Controller\User;

use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Model\PictureModel;

class UserController extends AbstractController {

    /**
     * Action responsable de l'affichage du dashboard
     */
    public function index()
    {
        // if(!UserSession::hasRoles('USER','EDITOR')){
        //     http_response_code(403);
        //     echo "Acces interdit";
        //     exit;
        // }

        return $this->render('user/user', [
            'picturesUser' => (new PictureModel())->getAllPictures(UserSession::getId())
        ]);
    }
}