<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class CategoryModel extends AbstractModel {

    public function getOneCategory(int $id)
    {
        $sql = 'SELECT *
                FROM category
                WHERE id = ?';
    
        $category = $this->database->getOneResult($sql, [$id]);
    
        return $category;
    }

    public function getAllCategories()
    {
        $sql = 'SELECT *
                FROM category
                ORDER BY label';
    
        return $this->database->getAllResults($sql);
    }

}