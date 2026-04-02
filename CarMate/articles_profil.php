<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Vos articles mis en vente';
    include('includes/head.php');
?>

<body>
    <?php 
    include('includes/db.php');
    include('includes/headerSecond.php');

    $query = 'SELECT idvente, produit, prix, etat, categorie, dateCreation, vendu FROM offre WHERE iduser = :iduser AND vendu IS NULL';
    $statement = $bdd->prepare($query);
    $statement->execute([
        ':iduser' => $_SESSION['iduser']
    ]);
    $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <main class="main-connexion">
        <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5" style="width:70%">
                <h1>Vos articles en vente</h1>
                <div class="line5 mb-2"></div>
                <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'success'): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                    </div>
                    <?php unset($_SESSION['flash_message']); ?>
                <?php endif; ?>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Categorie</th>
                        <th scope="col">Prix</th>
                        <th scope="col">État</th>
                        <th scope="col">Date de mise en vente</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($article['produit']); ?></td>
                                <td><?php echo htmlspecialchars($article['categorie']); ?></td>
                                <td><?php echo htmlspecialchars($article['prix']); ?></td>
                                <td><?php echo htmlspecialchars($article['etat']); ?></td>
                                <td><?php echo htmlspecialchars($article['dateCreation']); ?></td>
                                <?php if($article['vendu'] == null){ ?>
                                <td>
                                    <form method="POST" action="traitement_sup_enregistrement.php">
                                        <input type="hidden" name="idvente" value="<?php echo htmlspecialchars($article['idvente']); ?>">
                                        <button class="btn" id="boutonSuppression" name="suppression_article">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Aucun article mis en vente pour le moment</td>
                        </tr>
                    <?php endif; ?>    
                    </tbody>
                </table>
                <a href="profil.php"><p class="mt-3">Retourner à la page profil</p></a>
            </div>
        </div>
    </main>
</body>