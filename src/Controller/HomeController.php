<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\PictureModel;
use App\Model\CategoryModel;

class HomeController extends AbstractController {

    public function index()
    {
        // $categoryId = null;
        // if (array_key_exists('category', $_GET) && isset($_GET['category']) && ctype_digit($_GET['category'])) {
        //     $categoryId = $_GET['category'];
        // }

        $pictureModel = new PictureModel();
        $lastPictures = $pictureModel->getLastPictures();
        $bestPictures = $pictureModel->getBestPictures();

        // $category = null;
        // if ($categoryId) {
        //     $categoryModel = new CategoryModel();
        //     $category = $categoryModel->getOneCategory($categoryId);
        // }

        // Affichage : inclusion du template
        return $this->render('home', [
            'lastPictures' => $lastPictures,
            'bestPictures' => $bestPictures
        ]);
    }
}
