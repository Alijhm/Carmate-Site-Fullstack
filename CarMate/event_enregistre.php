<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Événements enregistrés';
    include('includes/head.php');
?>

<body>
    <?php 
    include('includes/db.php');
    include('includes/headerSecond.php');

    $query = 'SELECT evenement.idevent, evenement.titre, evenement.ville, evenement.dateDebut, evenement.dateFin, evenement.duree, evenement.prixEntree 
    FROM evenement JOIN inscrit ON evenement.idevent = inscrit.ideventsub
    WHERE inscrit.idusersub = :iduser';
    $statement = $bdd->prepare($query);
    $statement->execute([
        ':iduser' => $_SESSION['iduser'],
    ]);
    $favoris = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <main class="main-connexion">
        <div class="fond-connexion">
            <div class="col-4 fond-formulaireConnexion mt-5" style="width:70%">
                <h1>Les événements qui vous intéressent</h1>
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
                        <th scope="col">Titre</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Date de début</th>
                        <th scope="col">Date de fin</th>
                        <th scope="col">duree</th>
                        <th scope="col">prixEntree</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($favoris)): ?>
                        <?php foreach ($favoris as $favori): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($favori['titre']); ?></td>
                                <td><?php echo htmlspecialchars($favori['ville']); ?></td>
                                <td><?php echo htmlspecialchars($favori['dateDebut']); ?></td>
                                <td><?php echo htmlspecialchars($favori['dateFin']); ?></td>
                                <td><?php echo htmlspecialchars($favori['duree']); ?></td>
                                <td><?php echo htmlspecialchars($favori['prixEntree']); ?></td>
                                <td>
                                    <form method="POST" action="traitement_sup_enregistrement.php">
                                        <input type="hidden" name="idevent" value="<?php echo htmlspecialchars($favori['idevent']); ?>">
                                        <button class="btn" id="boutonSuppression" name="suppression_enregistrement_event">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun événement enregistré pour le moment</td>
                        </tr>
                    <?php endif; ?>    
                    </tbody>
                </table>
                <a href="profil.php"><p class="mt-3">Retourner à la page profil</p></a>
            </div>
        </div>
    </main>
</body>