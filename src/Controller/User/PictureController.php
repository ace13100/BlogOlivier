<?php 

namespace App\Controller\User;

use App\Framework\AbstractController;
use App\Model\CategoryModel;
use App\Model\PictureModel;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\UserModel;

class PictureController extends AbstractController {

    /**
     * Création d'un nouvel article
     */
    public function new()
    {
        // Si le formulaire est soumis 
        if (!empty($_POST)) {

            
            
            if(isset($_FILES['fileToUpload'])){
                $tmpName = $_FILES['fileToUpload']['tmp_name'];
                $name = trim($_FILES['fileToUpload']['name']);
                $size = $_FILES['fileToUpload']['size'];
                $error = $_FILES['fileToUpload']['error'];

                
                if(!file_exists("upload")){
                    mkdir("upload",0777, true);
                }
                if(is_uploaded_file($tmpName) ){
                    move_uploaded_file($tmpName,"upload"."/".str_replace(" ","_",$name));
                }
               
                
            }

            // On récupère les données du formulaire
            
            $description = $_POST['description'];
            $tags = $_POST['tags'];

            // On valide les données
            if (!$name) {
                FlashBag::addFlash('Le champ "name" est obligatoire', 'error');
            }

            if (!$tags) {
                FlashBag::addFlash('Le champ "tags" est obligatoire', 'error');
            }

            if (!$description) {
                FlashBag::addFlash('Le champ "description" est obligatoire', 'error');
            }

            // Si aucune erreur
            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                $userModel = new UserModel();
                $pictureModel = new PictureModel();
                $pictureModel->insert($size, str_replace(" ","_",$name), $description, $tags,UserSession::getId());
                
                // Message flash
                FlashBag::addFlash('Picture ajouté avec succès.');
                
                // Redirection vers le dashboard user
                $this->redirect('user');
            }
        }

        // Dans tous les cas... il faut aller chercher les catégories pour afficher la liste déroulante
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        // Affichage du template
        return $this->render('admin/article/new', [
            'name' => $name??'',
            'description' => $description??'',
            'tags' => $tags??null
        ]);
    }
}