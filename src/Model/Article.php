<?php

namespace App\Model;

use App\Container\Container;

class Article  extends AbtractModel
{
    private \PDOStatement $_statementCreateOne;
    private \PDOStatement $_statementUpdateOne;
    private \PDOStatement $_statementDeleteOne;
    private \PDOStatement $_statementReadOne;
    private \PDOStatement $_statementReadAll;
    private \PDOStatement $_statementReadUserAll;

    /**
     * Constructor
     *
     * @param mixed $pdo - 
     * 
     * @return void
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->_statementCreateOne = $this->db->prepare(
            "INSERT INTO article (
                title,
                image,
                category,
                content,
                author
            ) VALUES (
                :title,
                :image,
                :category,
                :content,
                :author
            )
            "
        );
        $this->_statementUpdateOne = $this->db->prepare(
            "UPDATE article 
            SET
                title = :title,
                image = :image,
                category = :category,
                content =  :content,
                author = :author
            WHERE id= :id
            "
        );
        $this->_statementReadOne   = $this->db->prepare(
            "SELECT article.*, user.firstname, user.lastname
            FROM article LEFT JOIN user ON article.author = user.id WHERE article.id= :id"
        );
        $this->_statementReadAll   = $this->db->prepare(
            ' SELECT article.*, user.firstname, user.lastname FROM article 
            LEFT JOIN user ON article.author = user.id
            '
        );
        $this->_statementDeleteOne = $this->db->prepare(
            'DELETE FROM article WHERE id =:id'
        );
        $this->_statementReadUserAll = $this->db->prepare(
            'SELECT * FROM article WHERE author=:authorId'
        );
    }
    /**
     * FetchAll
     *
     * @return array
     */
    public function fetchAll(): array
    {
        $this->_statementReadAll->execute();
        return $this->_statementReadAll->fetchAll();
    }
    /**
     * FetchOne
     *
     * @param int $id - 
     * 
     * @return array
     */
    public function fetchOne(int $id): array
    {
        $this->_statementReadOne->bindValue(":id", $id);
        $this->_statementReadOne->execute();
        return $this->_statementReadOne->fetch();
    }

    /**
     * DeleteOne
     *
     * @param int $id - 
     * 
     * @return string
     */
    public function deleteOne(int $id): string
    {
        $this->_statementDeleteOne->bindValue(':id', $id);
        $this->_statementDeleteOne->execute();
        return $id;
    }

    public function createOne($article)
    {
        $this->_statementCreateOne->bindValue(':title', $article['title']);
        $this->_statementCreateOne->bindValue(':image', $article['image']);
        $this->_statementCreateOne->bindValue(':category', $article['category']);
        $this->_statementCreateOne->bindValue(':content', $article['content']);
        $this->_statementCreateOne->bindValue(':author', $article['author']);
        $this->_statementCreateOne->execute();
        return $this->fetchOne($this->db->lastInsertId('id'));
    }
    public function updateOne($article): array
    {
        $this->_statementUpdateOne->bindValue(':title',  $article['title']);
        $this->_statementUpdateOne->bindValue(':image', $article['image']);
        $this->_statementUpdateOne->bindValue(':category', $article['category']);
        $this->_statementUpdateOne->bindValue(':content', $article['content']);
        $this->_statementUpdateOne->bindValue(':author', $article['author']);
        $this->_statementUpdateOne->bindValue(':id', $article['id']);
        $this->_statementUpdateOne->execute();

        return $article;
    }

    public function fetchUserArticle(string $authorId): array
    {
        $this->_statementReadUserAll->bindValue(':authorId', $authorId);
        $this->_statementReadUserAll->execute();
        return $this->_statementReadUserAll->fetchAll();
    }
}
