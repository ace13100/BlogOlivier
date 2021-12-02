<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;
use App\Model\CategoryModel;

class HomeController extends AbstractController {

    public function index()
    {
        $categoryId = null;
        if (array_key_exists('category', $_GET) && isset($_GET['category']) && ctype_digit($_GET['category'])) {
            $categoryId = $_GET['category'];
        }

        $articleModel = new ArticleModel();
        $articles = $articleModel->getAllArticles($categoryId);

        $category = null;
        if ($categoryId) {
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getOneCategory($categoryId);
        }

        // Affichage : inclusion du template
        return $this->render('home', [
            'articles' => $articles,
            'category' => $category
        ]);
    }
}
