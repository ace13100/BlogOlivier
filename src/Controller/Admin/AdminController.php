<?php 

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Model\ArticleModel;
use App\Model\PictureModel;

class AdminController extends AbstractController {

    /**
     * Action responsable de l'affichage du dashboard
     */
    public function index()
    {
        if(!UserSession::hasRoles('ADMIN')){
            http_response_code(403);
            echo "Acces interdit";
            exit;
        }
        return $this->render('admin/admin', [
            'pictures' => (new PictureModel())->getAllPictures()
        ]);
    }
}