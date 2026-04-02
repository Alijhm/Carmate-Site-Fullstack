<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php
    $pageTitle = 'CarMate — Articles filtrés';
    include('includes/head.php');
?>

<body class="event-page">
    <?php
    include('includes/header.php');?>
    <?php
        $articles = $_SESSION['filtrage'];
    ?>
    <main class="row">   
        <div class="col-2 ms-5 colResultats">
            <h1>Résultats | <a href="garage.php" id="nouvelleRecherche">Nouvelle recherche</a></h1>
                <div class="line5 mb-2 ms-2"></div>
                <p><em>CarMate vous présente les articles les plus adaptés à votre recherche !</em></p>
                <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'danger'): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>
            <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'success'): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>
        </div> 
        <div class="col-9 zone-event">
            <div class="row ms-4 mt-5 mb-2">
                <?php if (!empty($articles)): ?>
                    <?php foreach($articles as $article): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body">
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
                                        <div class="col-9 ms-3">
                        <a href="page_article.php?id= <?= $article['idvente'] ?>" style="color:black;" class="cardArticle">
                                            <h5 class="card-title"><?= htmlspecialchars($article['produit']) ?></h5>
                                            <div class="line5 mb-2"></div>
                                        </div>
                                    </div>
                                    <p class="card-text">
                                        <strong>Catégorie :</strong> <?= htmlspecialchars($article['categorie']) ?><br>
                                        <?= htmlspecialchars($article['description']) ?><br>
                                        <strong>Prix :</strong> <?= htmlspecialchars($article['prix']) ?>€<br>
                                        <strong>État :</strong> <?= htmlspecialchars($article['etat']) ?><br>
                                        <strong>Mis en vente le :</strong> <?= htmlspecialchars($article['dateCreation']) ?><br>
                                        <strong>Mis en vente par :</strong> <?= htmlspecialchars($article['nomUtilisateur']) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p><strong>Malheureusement aucun articles ne correspond à vos recherche.<br>Essayez d'être plus souple dans vos filtres.</strong></p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include('includes/footer.php');?>
</body>
</html>
