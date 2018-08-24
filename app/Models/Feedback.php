<?php

namespace App\Models;

use App\Library\BaseModel;

class Feedback extends BaseModel
{
    public function getAll($page=1, $limit=20) {
        $page = $page > 0 ? $page - 1 : 0;
        $sql = "SELECT * FROM `feedbacks` LIMIT $page, $limit";
        $statement = static::$pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @param array $post
     * @return boolean
     * @throws \Exception
     */
    public function save(array $post)
    {
        $sql = "INSERT INTO feedbacks(`name`, `email`, `text`) values (:name, :email, :text)";
        $statement= static::$pdo->prepare($sql);
        $statement->bindParam(':name', $post['name']);
        $statement->bindParam(':email', $post['email']);
        $statement->bindParam(':text', $post['text']);

        $result = $statement->execute();
        if (!$result) {
            throw new \Exception($statement->errorInfo());
        }

        return true;
    }
}