<?php
session_start();

require_once("./classes/commentClass.php");
require_once("./classes/articleClass.php");
require_once("./classes/likeClass.php");

$article = new Article();
$result = $article->displayArticle($_GET["id"]);

$likes = new Like();
$nbrLike = $likes->numberLikes($_GET["id"]);

$comments = $article->comment->displayCommentOfArticle($_GET["id"]);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="bg-[#A94F4F]">
    <?php include_once("./php/menu.php") ?>

    <main class="main w-[80vw] mx-auto my-0">
        <div class="articleImage w-full h-[40vh] overflow-hidden flex justify-center items-center">
            <img src="./assets/images/<?php echo $result["image"]; ?>" alt="">
        </div>
        <h1 class="title text-xl font-[bold] mx-0 my-2.5"><?php echo $result["title"]; ?></h1>
        <p class="article mx-0 my-2.5"><?php echo $result["article"]; ?></p>

        <?php if(isset($_SESSION['username'])){  ?>
        <form action="./php/ajouterCommentaireFormSubmit.php" method="POST">
            <textarea placeholder="Inserer votre commentaire ici ..." class="comment w-full" name="comment" id=""></textarea>
            <input hidden name="idArticle" value="<?php echo $_GET["id"]; ?>" type="text">
            <div>
                <button class="submit text-[white] bg-[brown] mx-0 my-2.5 p-[5px] rounded-[5px]" type="submit">Commenter</button>
                <label for="like" class="likeButton bg-[coral] text-[white] cursor-pointer w-fit mx-0 my-2.5 p-[5px] rounded-[5px]">
                    Like
                    <input hidden id="like" name="like" type="checkbox">
                    <?php if($nbrLike["numLike"] > 0){
                        echo $nbrLike["numLike"];
                    }else{
                        echo 0;
                    } ?>
                </label>
            </div>
            
        </form>
        <?php } ?>
        
        <div class="comments mt-[20px]">
            <h2>Commentaires:</h2>

            <?php foreach($comments as $comment){ ?>
            <div class="commentCard bg-[linear-gradient(-45deg,burlywood,rgb(255,178,123))] mx-0 my-[15px] p-2.5 rounded-[10px]">
                <?php echo $comment["comment"]; ?>
            </div>
            <?php } ?>

        </div>
    </main>
    










    <script src="./assets/js/afficherArticleScript.js"></script>
    <script src="./assets/js/indexScript.js"></script>

</body>
</html>