<!DOCTYPE html>
<html lang="en">

<?php
    include('includes/db.php');

    session_start();

    $idvente = $_GET['id'];

    $query = 'SELECT offre.iduser, idvente, produit, prix, etat, offre.description, categorie, dateCreation, nomUtilisateur 
    FROM offre INNER JOIN utilisateur ON offre.iduser = utilisateur.iduser WHERE idvente = :idvente';
    $statement = $bdd->prepare($query);
    $statement->execute([
        'idvente' => $idvente
    ]);
    $article = $statement->fetch(PDO::FETCH_ASSOC);
?>

<?php 
    $pageTitle = 'CarMate — ' . $article['produit'];
    include('includes/head.php');
?>

<body>
    <?php include('includes/headerSecond.php');?>
    <main>
    <div class="fond-connexion">
            <div class="col-6 fond-formulaireConnexion2 mt-5">
                <div class="row">
                    <div class="col-1">
                        <form method="POST" action="panier.php">
                            <input type="hidden" name="nom" value="<?= $article['produit'] ?>"></input> 
                            <input type="hidden" name="prix" value="<?= $article['prix'] ?>"></input>
                            <input type="hidden" name="idvente" value="<?= $article['idvente'] ?>"></input>
                            <button class="boutonLike" name="ajouterArticle">
                                <svg xmlns="http://www.w3.org/2000/svg" style="color:#f52938" width="32" height="32" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="col-11">
                        <h3><?= $article['produit'] ?></h3>
                        <div class="line5 mb-4"></div>
                    </div>
                </div>
                <div class="articleText">
                    <strong>Catégorie :</strong> <?= htmlspecialchars($article['categorie']) ?><br>
                    <?= htmlspecialchars($article['description']) ?><br>
                    <strong>Prix :</strong> <?= htmlspecialchars($article['prix']) ?>€<br>
                    <strong>État :</strong> <?= htmlspecialchars($article['etat']) ?><br>
                    <strong>Mis en vente le :</strong> <?= htmlspecialchars($article['dateCreation']) ?><br>
                    <strong>Mis en vente par :</strong>
                    <a style="text-decoration:none;color:black;" href="<?= $article['iduser'] == $_SESSION['iduser'] ? 'profil.php' : 'profil_autre.php?id=' . $article['iduser'] ?>">
                        <?= htmlspecialchars($article['nomUtilisateur']) ?>
                    </a> 
                </div>                 
            </div>
        </div>
    </main>
</body>                                                            