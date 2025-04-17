<?php

class Comment{

    private $id;
    private $comment;
    private $idArticle;
    private $idUser;
    private $connection;

    public function __construct(){
        try{
            $this->connection = new PDO('mysql:host=localhost;dbname=blognum2;charset=utf8', 'root', 'azl,kkk!');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    //function qui permet d inserer un comment avec like si inclu dans un article
    public function saveComment($comment, $idUser, $idArticle){
        $stmt = $this->connection->prepare("INSERT INTO comments (comment, idUser, idArticle) VALUES (:comment, :idUser, :idArticle);");

        $stmt->bindParam(":comment", $comment);
        $stmt->bindParam(":idUser", $idUser);
        $stmt->bindParam(":idArticle", $idArticle);

        $stmt->execute();
        header("Location: ../afficherArticle.php?id=$idArticle");
    }

    //fonction qui permet d'afficher tous les commentaires d'un article
    public function displayCommentOfArticle($idArticle){
        $stmt = $this->connection->prepare("SELECT * FROM comments WHERE idArticle = :idArticle");
        $stmt->bindParam(":idArticle", $idArticle);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    //fonction qui permet d'afficher tous les commentaires du blog pour admin
    public function displayAllComments(){
        $stmt = $this->connection->prepare("SELECT * FROM comments");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    //fonction qui permet de chercher un ou plusieurs commentaires pour admin
    public function searchComments($comment){
        $commentToSearch = "%" . $comment . "%";
        $stmt = $this->connection->prepare("SELECT * FROM comments WHERE comment LIKE :comment");
        $stmt->bindParam(":comment", $commentToSearch);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //la fonction qui permet d afficher tous les commentaires d un utilisatur
    public function displayAllCommentsUser($idUser){
        $stmt = $this->connection->prepare("SELECT * FROM comments WHERE idUser = :idUser");
        $stmt->bindParam(":idUser", $idUser);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

        //fonction qui permet de chercher un ou plusieurs commentaires pour ustilisateur
        public function searchCommentsUser($comment, $idUser){
            $commentToSearch = "%" . $comment . "%";
            $stmt = $this->connection->prepare("SELECT * FROM comments WHERE idUser = :idUser AND comment LIKE :comment");
            $stmt->bindParam(":comment", $commentToSearch);
            $stmt->bindParam(":idUser", $idUser);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }


}