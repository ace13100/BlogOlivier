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

            $pictureModel = new PictureModel();
            // On valide les données
            
            
            if(isset($_FILES['fileToUpload'])){
                $tmpName = $_FILES['fileToUpload']['tmp_name'];
                $name = trim($_FILES['fileToUpload']['name']);
                $size = $_FILES['fileToUpload']['size'];
                $error = $_FILES['fileToUpload']['error'];
                if($pictureModel->getPictureByName(str_replace(" ","_",$name))){
                    FlashBag::addFlash('Le champ "name" est deja utiliser par une autre picture', 'error');
                    
                } 
            }

            // On récupère les données du formulaire
            
            $description = $_POST['description'];
            $tags = $_POST['tags'];
            
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
                if(!file_exists("upload")){
                    mkdir("upload",0777, true);
                }
                if(is_uploaded_file($tmpName) ){
                    move_uploaded_file($tmpName,"upload"."/".str_replace(" ","_",$name));
                }
                
                
                $pictureModel->insert($size, str_replace(" ","_",$name), $description, $tags,UserSession::getId());
                
                // Message flash
                FlashBag::addFlash('Picture ajouté avec succès.');
                
                // Redirection vers le dashboard user
                $this->redirect('user');
            }
        }

        // Dans tous les cas... il faut aller chercher les catégories pour afficher la liste déroulante
        

        // Affichage du template
        return $this->render('user/user', [
            'name' => $name??'',
            'description' => $description??'',
            'tags' => $tags??null,
            'picturesUser' => (new PictureModel())->getAllPicturesById(UserSession::getId())
        ]);
    }
    /**
     * Suppression d'un article
     */
    public function delete()
    {
        var_dump($_GET['idPicture']);
        // Validation de l'id de l'article dans l'URL
        if (!array_key_exists('idPicture', $_GET) || ! isset($_GET['idPicture']) || !ctype_digit($_GET['idPicture'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        // Sélection de l'id de l'article dans l'URL et conversion en entier
        $pictureId = (int) $_GET['idPicture'];

        // Suppression de l'article
        $pictureModel = new PictureModel();
        
        
        // $file = basename(__DIR__.'/public/upload/'.$pictureModel->getOnePicture($pictureId)['namePicture']);
        unlink(UPLOAD_DIR.'/'.$pictureModel->getOnePicture($pictureId)['namePicture']);
        // Message flash
        $pictureModel->delete($pictureId);
        FlashBag::addFlash('Article supprimé');
        
        // On retourne l'id en réponse à la requête AJAX
        echo "picture-".$pictureId;
        exit;
    }
    public function edit()
    {
        
        
        
         



        
        // Si le formulaire est soumis 
        if (!empty($_POST)) {
            

            
            
           

            // On récupère les données du formulaire
            $pictureModel = new PictureModel();
            $description = trim($_POST['description']);
            $tags = trim($_POST['tags']);
            $name =str_replace(" ","_",trim($_POST['name'])) ;
            $pictureId = (int) $_GET['idPicture'];
            
            

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
            if($pictureModel->getPictureByName($name)){
                FlashBag::addFlash('Le champ "name" est deja utiliser par une autre picture', 'error');
                
            } 

            // Si aucune erreur
            if (!FlashBag::hasMessages('error')) {
               
                // On enregistre les données dans la base
                $firstName = $pictureModel->getOnePicture($pictureId)['namePicture'];
                
                if(!strrchr($name,".")){

                    $type = strrchr($firstName,".");
                    rename(UPLOAD_DIR."/".$firstName,UPLOAD_DIR."/".$name.$type);

                    $pictureModel->update($name.$type,$description,$tags,$pictureId);

                }
                else{
                    rename(UPLOAD_DIR."/".$firstName,UPLOAD_DIR."/".$name);
                    $pictureModel->update($name,$description,$tags,$pictureId);
                }
                
                
                
                
                
                // Message flash
                FlashBag::addFlash('Picture modifié avec succès.');
                
                // Redirection vers le dashboard user
                $this->redirect('user');
            }
            
        }
        if (!array_key_exists('idPicture', $_GET) || !isset($_GET['idPicture']) || !ctype_digit($_GET['idPicture'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        // Sélection de l'id de l'article dans l'URL et conversion en entier
        $pictureId = (int) $_GET['idPicture'];

        
        $pictureModel = new PictureModel();
        $name = $pictureModel->getOnePicture($pictureId)['namePicture'];
        $description = $pictureModel->getOnePicture($pictureId)['descriptionPicture'];
        $tags = $pictureModel->getOnePicture($pictureId)['tagPicture'];
        
        // Affichage du template
        return $this->render('user/picture/edit', [
            'name' => $name??'',
            'description' => $description??'',
            'tags' => $tags??'',
            'idPicture' => $pictureId??''
            
        ]);
        
        // Dans tous les cas... il faut aller chercher les catégories pour afficher la liste déroulante
        
    }
}
