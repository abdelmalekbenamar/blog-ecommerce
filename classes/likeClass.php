<?php
class Like{

    private $connection;

    public function __construct(){
        try{
            $this->connection = new PDO('mysql:host=localhost;dbname=blognum2;charset=utf8', 'root', 'azl,kkk!');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    //fonction qui retourne le nombre de like d un article
    public function numberLikes($idArticle){
        $stmt = $this->connection->prepare("SELECT COUNT(*) as numLike from likes where idArticle = :idArticle;");
        $stmt->bindParam(":idArticle", $idArticle);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //fonction qui permet de enregistrer les likes de chaque article
    public function saveArticleLikes($idArticle, $idUser){
        $stmt = $this->connection->prepare("INSERT INTO likes (idUser, idArticle) values (:idUser, :idArticle);");
        $stmt->bindParam(":idUser", $idUser);
        $stmt->bindParam(":idArticle", $idArticle);
        $stmt->execute();
    }

}