<?php 

namespace App\Model;

use App\Framework\AbstractModel;

class CommentModel extends AbstractModel {

    function getAllComments(int $articleId): array
    {
        $sql = 'SELECT C.content, C.created_at, U.firstname, U.lastname
                FROM comment AS C
                INNER JOIN user AS U ON U.id = C.user_id
                WHERE article_id = ?
                ORDER BY C.created_at DESC';

        $comments = $this->database->getAllResults($sql, [$articleId]);

        return $comments;
    }

    function getOneComment(int $commentId)
    {
        $sql = 'SELECT C.content, C.created_at, U.firstname, U.lastname
                FROM comment AS C
                INNER JOIN user AS U ON U.id = C.user_id
                WHERE C.id = ?';

        $comment = $this->database->getOneResult($sql, [$commentId]);

        return $comment;
    }

    function insertComment(string $content, int $articleId, int $userId)
    {
        $sql = 'INSERT INTO comment
            (content, created_at, article_id, user_id) VALUES (?, NOW(), ?, ?)';

        return $this->database->insert($sql, [$content, $articleId, $userId]);
    }
}