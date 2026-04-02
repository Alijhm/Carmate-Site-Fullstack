<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php    
    $pageTitle = 'CarMate — Le garage';
    include('includes/head.php');

    include('includes/choix_theme.php');

    include('includes/reinitialisation_infos_quiz.php');

    include('includes/db.php');

    $query = 'SELECT idvente, produit, prix, etat, offre.description, categorie, dateCreation, nomUtilisateur 
    FROM offre INNER JOIN utilisateur on offre.iduser = utilisateur.iduser 
    WHERE vendu IS NULL
    ORDER BY dateCreation ASC';
    $statement = $bdd->prepare($query);
    $statement->execute();
    $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
    if(!isset($_SESSION['formulaire'])){
        $_SESSION['formulaire'] = 0;
    }

    if(isset($_POST['afficherFormulaire'])){
        $_SESSION['formulaire'] = 1;
    }

    if(isset($_POST['fermerFormulaire'])){
        $_SESSION['formulaire'] = 0;
    };

    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
?>
<body style="<?php if(isset($_SESSION['iduser'])):if($themeSombreClair == 0):?>background-color:rgb(89, 89, 89)   ;<?php endif;endif; ?>">
    <?php include('includes/header.php');?>

    <?php if($_SESSION['formulaire'] == 0){ ?>
    <main>
        <div class="fond-filtre">
            <nav class="navbar navbar-expand-lg">
                <div class="row">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse mt-4" id="navbarSupportedContent">
                            <form class="col-3" method="POST" action="traitement_recherche_event.php">
                                <div class="fond-recherche">
                                    <input class="form-control me-2" name='rechercheGarage' type="search" placeholder="Tapez votre recherche" aria-label="Search">
                                    <button class="btn" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="magnify bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <form class="d-flex col-8 ms-3" method="POST" action="traitement_filtre_event.php">
                                <input type="hidden" name="source" value="garage">
                                <select class="form-select" name="categorie">
                                    <option value="-1">Choisissez une catégorie</option>
                                    <option value="interieur">Accessoire intérieur</option>
                                    <option value="exterieur">Accessoire extérieur</option>
                                    <option value="piece">Piéce détachée</option>
                                </select>

                                <input type="number" class="form-control ms-2" id="validationCustom03" name="prix" 
                                value="" min="0" step="1" placeholder="Séléctionnez un budget">
                                
                                <select class="form-select ms-2" name="etat">
                                    <option value="-1">Choisissez le pire état que vous accepteriez</option>
                                    <option value="neuf">Neuf</option>
                                    <option value="utilise">Déjà utilisé</option>
                                    <option value="abime">Abimé</option>
                                    <option value="pasDePref">Pas de préférence</option> 
                                </select> 

                                <button type="submit" style="width:100px;" class="btn boutonRecherche ms-1">Recherche</button>
                            </form>

                            <form method="POST">
                                <button type="submit" name="afficherFormulaire" class="boutonAjoutOffre ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="line-largeur"></div>
        </div>

        <div class="container">
            <div class="row mt-5" style="padding-top:100px;">
                <div class="col-8">
                    <h1>Découvrez toutes les offres proposées par les utilisateurs CarMate ! Une vaste gamme d'équipements et pièces détachées variés.</h1>
                    <div class="line5 mb-4"></div>
                </div>

                <div class="col-4">
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
            </div>

            <div class="row">
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
            </div>
                </div>
            </div>
        </div>

    </main>
    <?php }elseif($_SESSION['formulaire'] == 1){ ?>
    <main>
        <div class="fond-voiture">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5" style="width:auto">
                    <form method="POST" action="traitement_garage.php">
                        <h1>Formulaire de mise en vente</h1>
                        <div class="line5 mb-4"></div>
                            <div class="row">
                                <div class="col-8">
                                    <label for="validationCustom01" class="form-label">Nom du produit</label>
                                    <input type="text" class="form-control <?php echo isset($errors['nom']) ? 'is-invalid' : ''; ?>" id="validationCustom01" name="nom">
                                </div>

                                <div class="col-4">
                                    <label for="validationCustom01" class="form-label">Catégorie</label>
                                    <select class="form-select" name="categorie">
                                        <option value="-1">Choisissez une catégorie</option>
                                        <option value="Accéssoire d'intérieur du véhicule">Accessoire intérieur</option>
                                        <option value="Accéssoire d'exterieur du véhicule">Accessoire extérieur</option>
                                        <option value="Piéce détachée automobile">Piéce détachée</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="validationCustom03" class="form-label">Prix (en €)</label>
                                    <input type="number" class="form-control <?php echo isset($errors['prix']) ? 'is-invalid' : ''; ?>" id="validationCustom03" name="prix" 
                                    min="0" step="1">
                                </div>

                                <div class="col-6">
                                    <label for="validationCustom01" class="form-label">État</label>
                                    <select class="form-select ms-2" name="etat">
                                        <option value="-1">Séléctionnez l'état du produit</option>
                                        <option value="Produit neuf, jamais utilisé">Neuf</option>
                                        <option value="Produit déjà utilisé">Déjà utilisé</option>
                                        <option value="Produit utilisé et abimé">Abimé</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12" id="event-description">
                                    <label for="name">Description (255 caractères max)</label>
                                    <input
                                    type="text"
                                    name="description"
                                    class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>"
                                    minlength="0"
                                    maxlength="255"
                                    size="100"
                                    />
                                </div>
                            </div>

                            <div class="col-12 btn-formulaire mt-5 d-flex" style="display:flex;justify-content:center;align-items:center;">
                                <button type="submit" class="btn-vld" style="display:flex;justify-content:center;align-items:center;">Valider la mise en vente</button>
                            </div>
                    </form>
                    <form method="POST">
                        <button type="submit" class="btn-cls2 me-4 mt-2" id="closeButton" name="fermerFormulaire" style="display:flex;justify-self:center;justify-content:center;align-items:center;background-color:#a8a8a8;width:200px;">Abandonner le formulaire</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php }elseif($_SESSION['formulaire'] == 2){ ?>
        <main>
        <div class="fond-voiture">
            <div class="fond-connexion">
                <div class="col-4 fond-formulaireConnexion mt-5" style="width:auto">
                    <form method="POST" action="traitement_garage_part2.php">
                        <h1>Formulaire de mise en vente</h1>
                        <div class="line5 mb-4"></div>
                            
                        <div class="row">
                            <p>Un produit similaire semble déjà être en vente depuis votre compte. Confirmez-vous qu’il s’agit bien d’un second article distinct ?</p>
                        </div>
                        <div class="col-12 btn-formulaire mt-5 d-flex" style="display:flex;justify-content:center;align-items:center;">
                            <button type="submit" class="btn-vld" style="display:flex;justify-content:center;align-items:center;">Oui</button>
                        </div>
                    </form>

                    <form method="POST">
                        <button type="submit" class="btn-cls2 me-4 mt-2" id="closeButton" name="fermerFormulaire" style="display:flex;justify-self:center;justify-content:center;align-items:center;background-color:#a8a8a8;width:200px;">Non</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php } ?>
    
    <script src="script.js"></script>
    <?php include('includes/lien_chatbot.php'); ?>
</body>
</html>