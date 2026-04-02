<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Votre panier';
    include('includes/head.php');
?>

<body>
    <?php 
    include('includes/db.php');
    include('includes/headerSecond.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouterArticle'])){

        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = [];
        }

        $redondant = 0;
        foreach($_SESSION['panier'] as $article){
            if($article['idvente'] == $_POST['idvente']){
                $redondant = 1;
            }
        }

        if($redondant){
            $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Article déjà ajouté au panier.",
            ];
            header('location:garage.php');
            exit();
        }

        $_SESSION['panier'][] = [
            'produit' => $_POST['nom'],
            'prix' => $_POST['prix'],
            'idvente' => $_POST['idvente']
        ];

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Article ajouté au panier.",
        ];
        header('location:garage.php');
        exit();
    }

    $_SESSION['total'] = 0;
    ?>

    <main class="main-connexion">
        <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5" style="width:70%">
                <h1>Les articles qui vous intéressent</h1>
                <div class="line5 mb-2"></div>
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
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Produit</th>
                        <th scope="col">Prix</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_SESSION['panier'])): ?>
                        <?php foreach ($_SESSION['panier'] as $article): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($article['produit'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($article['prix'] ?? ''); ?></td>
                                <td>
                                    <form method="POST" action="traitement_sup_enregistrement.php">
                                        <input type="hidden" name="idvente" value="<?php echo htmlspecialchars($article['idvente']); ?>">
                                        <button class="btn" id="boutonSuppression" name="suppression_articles_panier">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php $_SESSION['total'] += $article['prix']; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun article dans votre panier pour le moment</td>
                        </tr>
                    <?php endif; ?>    
                    </tbody>
                </table>
                <?php if(isset($_SESSION['panier'])){ ?>
                    <p><strong>Somme totale : </strong><span class="badge text-bg-success" id="prixAffiche"> <?= $_SESSION['total'] ?> </span>€</p>
                    <form method="POST" action="checkout.php">
                        <button type="submit" style="width:100px;" class="btn boutonRecherche">Payer</button>
                    </form>
                <?php } ?>
                <a href="garage.php"><p class="mt-2">Retourner à vos achats</p></a>
            </div>
        </div>
    </main>
</body>