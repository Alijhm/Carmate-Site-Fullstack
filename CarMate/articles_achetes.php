<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Vos articles achetés';
    include('includes/head.php');
?>

<body>
    <?php 
    include('includes/db.php');
    include('includes/headerSecond.php');

    if (isset($_POST['action']) && $_POST['action'] == 'pdf') {
        $facture = [
            'produit' => $_POST['produit'],
            'categorie' => $_POST['categorie'],
            'prix' => $_POST['prix'],
            'etat' => $_POST['etat'],
            'vendeur' => $_POST['vendeur'],
            'description' => $_POST['description'],
            'dateAchat' => $_POST['dateAchat']
        ];
        
        $_SESSION['facture'] = $facture;
        $_SESSION['pdf'] = 1;
    }


    $query = 'SELECT idvente, produit, prix, etat, categorie, offre.description, dateAchat, nomUtilisateur 
    FROM offre JOIN utilisateur ON offre.iduser = utilisateur.iduser WHERE idacheteur = :idacheteur';
    $statement = $bdd->prepare($query);
    $statement->execute([
        ':idacheteur' => $_SESSION['iduser']
    ]);
    $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <main class="main-connexion">
        <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5" style="width:50%">
                <h1>Vos articles achetés</h1>
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
                            <th scope="col">Prix</th>
                            <th scope="col">Date d'achat</th>
                            <th scope="col">Facture</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($article['produit']); ?></td>
                                <td><?php echo htmlspecialchars($article['prix']); ?></td>
                                <td><?php echo htmlspecialchars($article['dateAchat']); ?></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="pdf">
                                        <input type="hidden" name="produit" value="<?php echo htmlspecialchars($article['produit']); ?>">
                                        <input type="hidden" name="categorie" value="<?php echo htmlspecialchars($article['categorie']); ?>">
                                        <input type="hidden" name="dateAchat" value="<?php echo htmlspecialchars($article['dateAchat']); ?>">
                                        <input type="hidden" name="prix" value="<?php echo htmlspecialchars($article['prix']); ?>">
                                        <input type="hidden" name="etat" value="<?php echo htmlspecialchars($article['etat']); ?>">
                                        <input type="hidden" name="vendeur" value="<?php echo htmlspecialchars($article['nomUtilisateur']); ?>">
                                        <input type="hidden" name="description" value="<?php echo htmlspecialchars($article['description']); ?>">
                                        <button class="btn" id="boutonSuppression">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun article acheté pour le moment</td>
                        </tr>
                    <?php endif; ?>    
                    </tbody>
                </table>
                <a href="profil.php"><p class="mt-3">Retourner à la page profil</p></a>
            </div>
        </div>
    </main>

    <script>

        <?php if(isset($_SESSION['pdf']) && $_SESSION['pdf'] == 1): ?>
            
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const nom = "<?php echo htmlspecialchars($_SESSION['facture']['produit']); ?>";
            const categorie = "<?php echo htmlspecialchars($_SESSION['facture']['categorie']); ?>";
            const dateAchat = "<?php echo htmlspecialchars($_SESSION['facture']['dateAchat']); ?>";
            const prix = "<?php echo htmlspecialchars($_SESSION['facture']['prix']); ?>";
            const etat = "<?php echo htmlspecialchars($_SESSION['facture']['etat']); ?>";
            const vendeur = "<?php echo htmlspecialchars($_SESSION['facture']['vendeur']); ?>";
            const description = "<?php echo htmlspecialchars($_SESSION['facture']['description']); ?>";
            
            doc.setFontSize(18);
            doc.setFont("bold");
            doc.text("Détails de l'article achetés sur les système e-commerce CarMate", 10, 10);

            doc.setDrawColor(245, 41, 56);
            doc.setLineWidth(1.5);
            doc.line(10, 14, 200, 14);

            doc.setFontSize(12);
            doc.setFont("normal");

            doc.text(`Nom du produit : ${nom}`, 10, 30);
            doc.text(`Catégorie du produit : ${categorie}`, 10, 40);
            doc.text(`Prix de vente : ${prix}`, 10, 50);
            doc.text(`État du produit au moment de la vente : ${etat}`, 10, 60);
            doc.text(`Vendeur : ${vendeur}`, 10, 70);
            doc.text(`Date d'achat du produit (il est retenu ici précisément la date à laquelle le paiement à eu lieu) : ${dateAchat}`, 10, 80);
            doc.text(`Description générale du produit : ${description}`, 10, 90);
            
            const descriptionBorne = doc.splitTextToSize(
                `Description : ${description}`,
                180
            );
            doc.text(descriptionBorne, 10, 90);

            doc.save("CarMate_Facture_" + nom + ".pdf");

            <?php
            unset($_SESSION['pdf']);
            unset($_SESSION['facture']);
            ?>  

            <?php endif; ?>

    </script>
</body>