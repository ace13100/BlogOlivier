<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class PictureModel extends AbstractModel {
    
    /**
     * Sélectionne un article à partir de son identifiant
     */
    function getOnePicture(int $id): array
    {
        $sql = 'SELECT *
                FROM pictures AS p
                INNER JOIN users AS U ON U.idUser = p.idUser
                WHERE p.idPicture = ?';
    
        $article = $this->database->getOneResult($sql, [$id]);
    
        return $article;
    }
    function getAllPicturesById(int $idUser): array
    {
        $sql = 'SELECT *
                FROM pictures AS p
                INNER JOIN users AS u ON u.idUser = p.idUser
                WHERE u.idUser = ?';
    
        $article = $this->database->getAllResults($sql, [$idUser]);
    
        return $article;
    }
    

    /**
     * Sélectionne plusieurs articles
     * Le paramètre $categoryId est facultatif. S'il n'est pas présent ou si sa valeur est null, tous les articles sont sélectionnés
     * Si le paramètre $categoryId est présent et non null, on sélectionne uniquement les articles de la catégorie correspondante
     * 
     * Rem. : la jointure va chercher les données dans 2 tables qui ont le champ id en commun. Il est alors nécessaire 
     *        de spécifier dans la clause SELECT les champs individuellement en précisant éventuellement pour les champs ambigus la table et un alias
     */
    function getPictureByName(string $namePicture){
        $sql = 'SELECT *
                FROM pictures AS P
                where namePicture = ?';
        $articles = $this->database->getOneResult($sql,[$namePicture]);

        return $articles;

    }
    function getAllPictures(): array
    {
        $sql = 'SELECT *
                FROM pictures AS P
                inner join users as u on u.idUser = P.idUser';

        // $params = [];

        // /**
        //  * Si on cherche les articles d'une catégorie spécifique, on ajoute une clause WHERE à la requête SQL pour filtrer les articles sur cette catégorie
        //  * On complète également le tableau de paramètres
        //  */
        // if ($categoryId) {
        //     $sql .= ' WHERE A.category_id = ?';
        //     $params[] = $categoryId;
        // }
                
        // $sql .= ' ORDER BY A.created_at DESC';

        $articles = $this->database->getAllResults($sql);

        return $articles;
    }
    function getLastPictures(): array
    {
        $sql = 'SELECT namePicture,P.createdAt
                FROM pictures AS P
                ORDER BY createdAt DESC
                LIMIT 10';

        // $params = [];

        // /**
        //  * Si on cherche les articles d'une catégorie spécifique, on ajoute une clause WHERE à la requête SQL pour filtrer les articles sur cette catégorie
        //  * On complète également le tableau de paramètres
        //  */
        // if ($categoryId) {
        //     $sql .= ' WHERE A.category_id = ?';
        //     $params[] = $categoryId;
        // }
                
        // $sql .= ' ORDER BY A.created_at DESC';

        $articles = $this->database->getAllResults($sql);

        return $articles;
    }

    function getBestPictures(): array
    {
        $sql = 'SELECT namePicture,nbDownload
                FROM pictures AS P
                ORDER BY nbDownload DESC
                LIMIT 10';

        // $params = [];

        // /**
        //  * Si on cherche les articles d'une catégorie spécifique, on ajoute une clause WHERE à la requête SQL pour filtrer les articles sur cette catégorie
        //  * On complète également le tableau de paramètres
        //  */
        // if ($categoryId) {
        //     $sql .= ' WHERE A.category_id = ?';
        //     $params[] = $categoryId;
        // }
                
        // $sql .= ' ORDER BY A.created_at DESC';

        $articles = $this->database->getAllResults($sql);

        return $articles;
    }
    /**
     * Insert un article dans la base de données
     */
    public function insert(int $sizePicture, string $namePicture, string $descriptionPicture,string $tagPicture,int $idUser)
    {
        $sql = 'INSERT INTO pictures 
                (sizePicture, namePicture, descriptionPicture, tagPicture,idUser ,createdAt)
                VALUES (?,?,?,?,?,NOW())';

        $this->database->executeQuery($sql, [$sizePicture, $namePicture, $descriptionPicture, $tagPicture,$idUser]);
    }

    /**
     * Modifie un article dans la base de données
     */
    public function update(string $namePicture, string $descriptionPicture, string $tagPicture,int $pictureId)
    {
        $sql = 'UPDATE pictures 
                SET namePicture = ?, descriptionPicture = ?, tagPicture = ?
                WHERE idPicture = ?';

        $this->database->executeQuery($sql, [$namePicture, $descriptionPicture, $tagPicture, $pictureId]);
    }

    /**
     * Modifie un article dans la base de données
     */
    public function delete(int $articleId)
    {
        $sql = 'DELETE FROM pictures 
                WHERE idPicture = ?';

        $this->database->executeQuery($sql, [$articleId]);


    }
}