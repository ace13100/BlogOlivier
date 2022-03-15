<?php 

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Model\CategoryModel;
use App\Model\PictureModel;
use App\Framework\FlashBag;
use App\Framework\UserSession;

class PictureController extends AbstractController {

    /**
     * Création d'un nouvel article
     */
    public function new()
    {
        // Si le formulaire est soumis 
        if (!empty($_POST)) {

            // On récupère les données du formulaire
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $category = intval($_POST['category']);

            // On valide les données
            if (!$title) {
                FlashBag::addFlash('Le champ "Titre" est obligatoire', 'error');
            }

            if (!$content) {
                FlashBag::addFlash('Le champ "Contenu" est obligatoire', 'error');
            }

            if (!$category) {
                FlashBag::addFlash('Le champ "Catégorie" est obligatoire', 'error');
            }

            // Si aucune erreur
            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                $articleModel = new PictureModel();
                $articleModel->insert($title, $content, $category, UserSession::getId());

                // Message flash
                FlashBag::addFlash('Article ajouté avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
        }

        // Dans tous les cas... il faut aller chercher les catégories pour afficher la liste déroulante
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        // Affichage du template
        return $this->render('admin/article/new', [
            'categories' => $categories,
            'title' => $title??'',
            'content' => $content??'',
            'selectedCategory' => $category??null
        ]);
    }


    /**
     * Modification d'un nouvel article
     */
    public function edit()
    {
        // Validation de l'id de l'article dans l'URL
        if (!array_key_exists('article_id', $_GET) || ! isset($_GET['article_id']) || !ctype_digit($_GET['article_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        // Sélection de l'id de l'article dans l'URL et conversion en entier
        $articleId = (int) $_GET['article_id'];

        // Création d'un objet ArticleModel dont on aura besoin dans tous les cas
        $articleModel = new PictureModel();

        // Si le formulaire est soumis... 
        if (!empty($_POST)) {

            // On récupère les données du formulaire
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $category = intval($_POST['category']);

            // On valide les données
            if (!$title) {
                FlashBag::addFlash('Le champ "Titre" est obligatoire', 'error');
            }

            if (!$content) {
                FlashBag::addFlash('Le champ "Contenu" est obligatoire', 'error');
            }

            if (!$category) {
                FlashBag::addFlash('Le champ "Catégorie" est obligatoire', 'error');
            }

            // Si aucune erreur
            if (!FlashBag::hasMessages('error')) {

                // On enregistre les données dans la base
                $articleModel->update($title, $content, $category, $articleId);

                // Message flash
                FlashBag::addFlash('Article modifié avec succès.');

                // Redirection vers le dashboard admin
                $this->redirect('admin');
            }
        }



        // Dans tous les cas... il faut aller chercher les catégories pour afficher la liste déroulante
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        // Et on a besoin des données de l'article à modifier pour pré remplir le formulaire
        $article = $articleModel->getOneArticle($articleId);

        if (!$article){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        return $this->render('admin/article/edit', [
            'articleId' => $article['article_id'],
            'categories' => $categories,
            'title' => $title ?? $article['title'], // Soit on prend la valeur du formulaire si elle existe, soit la valeur de la BDD
            'content' => $content ?? $article['content'],
            'selectedCategory' => $category ?? $article['category_id']
        ]);
    }


    /**
     * Suppression d'un article
     */
    public function delete()
    {
        // Validation de l'id de l'article dans l'URL
        if (!array_key_exists('article_id', $_GET) || ! isset($_GET['article_id']) || !ctype_digit($_GET['article_id'])){
            http_response_code(404); // On modifie le code de status de la réponse HTTP 
            echo '404 NOT FOUND'; // On affiche un message à l'internaute
            exit; // On arrête le script PHP, on n'a plus rien à faire ! 
        }

        // Sélection de l'id de l'article dans l'URL et conversion en entier
        $articleId = (int) $_GET['article_id'];

        // Suppression de l'article
        $articleModel = new PictureModel();
        $articleModel->delete($articleId);

        // Message flash
        FlashBag::addFlash('Article supprimé');

        // On retourne l'id en réponse à la requête AJAX
        echo $articleId;
        exit;
    }
}