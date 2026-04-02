<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office CarMate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<?php if(isset($_SESSION['user'])): ?>
<body onload="loadWelcome()">
    <header>
        <img src="image/logo1.png" alt="logo CarMate" width="225px">
    </header>
    <main>
        <div class="nav">
            <ul>
                <li><a href="#pagewelcome" onclick="showWelcome()">Accueil</a></li>

                <form id="connForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="conn">
                </form>
                <li><a href="#pageconnexion" onclick="hideWelcome(); document.getElementById('connForm').submit(); return false;" action="traitements.php">Utilisateurs connectés</a></li>

                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'admin'): ?>
                <form id="userForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="users">
                </form>
                <li><a href="#pageusers" onclick="hideWelcome(); document.getElementById('userForm').submit(); return false;">Gestion des utilisateurs</a></li>
                
                <form id="carForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="cars">
                </form>
                <li><a href="#pagecars" onclick="hideWelcome(); document.getElementById('carForm').submit(); return false;">Gestion des voitures</a></li>

                <form id="rightsForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="rights">
                </form>
                <li><a href="#pagerights" onclick="hideWelcome(); document.getElementById('rightsForm').submit(); return false;">Gestion des droits</a></li>

                <form id="quizForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="quiz">
                </form>
                <li><a href="#pagequiz" onclick="hideWelcome(); document.getElementById('quizForm').submit(); return false;">Gestion questions/réponses</a></li>

                <form id="captchaForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="captcha">
                </form>
                <li><a href="#pagecaptcha" onclick="hideWelcome(); document.getElementById('captchaForm').submit(); return false;">Gestion Captcha</a></li>
                <?php endif; ?>

                <form id="reportsForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="reports">
                </form>
                <li><a href="#pagereports" onclick="hideWelcome(); document.getElementById('reportsForm').submit(); return false;">Signalements</a></li>

                <form id="messagesForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="messages">
                </form>
                <li><a href="#pagemessages" onclick="hideWelcome(); document.getElementById('messagesForm').submit(); return false;">Contrôle des messages</a></li>

                <form id="mailsForm" method="POST" action="traitements.php">
                    <input type="hidden" name="action" value="mails">
                </form>
                <li><a href="#pagemails" onclick="hideWelcome(); document.getElementById('mailsForm').submit(); return false;">Mails automatiques</a></li>

                <li><a href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </div>

        <div class="right">
            <?php if(isset($_SESSION['flash_message']) && $_SESSION['flash_message']['type'] === 'success'): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo '<p>' . htmlspecialchars($_SESSION['flash_message']['message']) . '</p>'; ?>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>
            <div id="pagewelcome">
                <h1>Back Office CarMate</h1>
                <p>Utilisez la navigation à gauche pour accéder aux outils d'administration</p>
                </div>

            <section id="pageconnexion">
                <?php if(isset($_SESSION['listconn'])): ?>

                <h1>Utilisateurs connectés : <?php echo $_SESSION['total']; ?></h1>

                <div>
                    <form method="POST" action="traitement_search.php">
                        <input type="text" class="" name="searchvalue" placeholder="Rechercher un élément...">
                        <input type="hidden" name="action" value="conn">
                    </form>
                </div>
                <br>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Connecté ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=0; $i<count($_SESSION['listconn']); $i++){
                                echo '<tr>';
                                    echo '<th scope="row">' . htmlspecialchars($_SESSION['listconn'][$i][0]['iduser']) . '</th>';
                                    echo '<td>' . htmlspecialchars($_SESSION['listconn'][$i][0]['nomUtilisateur']) . '</td>';
                                    echo '<td>' . htmlspecialchars($_SESSION['listconn'][$i][0]['email']) . '</td>';
                                    if($_SESSION['listconn'][$i][0]['connexion']==0){
                                        echo '<td>Non</td>';
                                    }else{
                                        echo '<td>Oui</td>';
                                    }
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageConn" value="moins">Précedent</button>
                    <button type="submit" name="pageConn" value="plus">Suivant</button>
                    <button type="submit" name="pageConn">Rafraîchir</button>
                </form>
                <?php endif; ?>
            </section>

            <section id="pageusers">
                <?php if(isset($_SESSION['listusers'])): ?>
                <h1>Liste des utilisateurs</h1>

                <div>
                    <form method="POST" action="traitement_search.php">
                        <input type="text" class="" name="searchvalue" placeholder="Rechercher un élément...">
                        <input type="hidden" name="action" value="users">
                    </form>
                </div>
                <br>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Date de naissance</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Rue</th>
                        <th scope="col">Description</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listusers']); $i++){
                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listusers'][$i][0]['iduser']) . '</th>';

                                        echo '<td><input class="mediumtext" type="text" name="newnomUtilisateur[' . $_SESSION['listusers'][$i][0]['iduser'] . ']" value="' . $_SESSION['listusers'][$i][0]['nomUtilisateur'] . '"></td>'; 
                                        
                                        echo '<td><input class="mediumtext" type="text" name="newdateDeNaissance[' . $_SESSION['listusers'][$i][0]['iduser'] . ']" value="' . $_SESSION['listusers'][$i][0]['dateDeNaissance'] . '"></td>';
                                        
                                        echo '<td><input class="mediumtext" type="text" name="newville[' . $_SESSION['listusers'][$i][0]['iduser'] . ']" value="' . $_SESSION['listusers'][$i][0]['ville'] . '"></td>';

                                        echo '<td><input class="bigtext" type="text" name="newrue[' . $_SESSION['listusers'][$i][0]['iduser'] . ']" value="' . $_SESSION['listusers'][$i][0]['rue'] . '"></td>';

                                        if(!empty($_SESSION['listusers'][$i][0]['description'])){
                                            echo '<td><input class="bigtext" type="text" name="newdescription[' . $_SESSION['listusers'][$i][0]['iduser'] . ']" value="' . $_SESSION['listusers'][$i][0]['description'] . '"></td>';
                                        } else {
                                            echo '<td><input class="bigtext" type="text" name="newdescription[' . $_SESSION['listusers'][$i][0]['iduser'] . ']"></td>';
                                        }

                                        echo '<td>' . htmlspecialchars($_SESSION['listusers'][$i][0]['email']) . '</td>';
                                        echo '<td>' . htmlspecialchars($_SESSION['listusers'][$i][0]['status']) . '</td>';

                                        echo '<td><button type="submit" name="updateuser" value="' . $_SESSION['listusers'][$i][0]['iduser'] . '">Update</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageUsers" value="moins">Précedent</button>
                    <button type="submit" name="pageUsers" value="plus">Suivant</button>
                    <button type="submit" name="pageUsers">Rafraîchir</button>
                </form>
                <?php endif; ?>
            </section>

            <section id="pagecars">
                <?php if(isset($_SESSION['listcars'])): ?>
                <h1>Liste des voitures</h1>

                <div>
                    <form method="POST" action="traitement_search.php">
                        <input type="text" class="" name="searchvalue" placeholder="Rechercher un élément...">
                        <input type="hidden" name="action" value="cars">
                    </form>
                </div>
                <br>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Marque</th>
                        <th scope="col">Année</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Description</th>
                        <th scope="col">Dimension</th>
                        <th scope="col">Moteur</th>
                        <th scope="col">Essence</th>
                        <th scope="col">Transmission</th>
                        <th scope="col">Hybride ?</th>
                        <th scope="col">Maniabilité</th>
                        <th scope="col">Image</th>
                        <th scope="col">Lien</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listcars']); $i++){
                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listcars'][$i][0]['idvoiture']) . '</th>';

                                        echo '<td><input class="bigtext" type="text" name="newnom[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['nom'] . '"></td>'; 
                                        
                                        echo '<td><input class="mediumtext" type="text" name="newmarque[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['marque'] . '"></td>'; 

                                        echo '<td><input class="smalltext" type="text" name="newannee[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['annee'] . '"></td>'; 

                                        echo '<td><input class="smalltext" type="text" name="newprix[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['prix'] . '"></td>'; 

                                        echo '<td><input class="bigtext" type="text" name="newdescription[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['description'] . '"></td>';

                                        echo '<td><input class="mediumtext" type="text" name="newdimension[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['dimension'] . '"></td>';

                                        echo '<td><input class="mediumtext" type="text" name="newmoteur[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['moteur'] . '"></td>';

                                        echo '<td><input class="mediumtext" type="text" name="newessence[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['essence'] . '"></td>';

                                        echo '<td><input class="bigtext" type="text" name="newtransmission[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['transmission'] . '"></td>';

                                        if($_SESSION['listcars'][$i][0]['hybride'] == 0){
                                            echo '<td><input class="smalltext" type="text" name="newhybride[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="Non"></td>';
                                        }else{
                                            echo '<td><input class="smalltext" type="text" name="newhybride[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="Oui"></td>';
                                        }

                                        echo '<td><input class="bigtext" type="text" name="newmaniabilite[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['maniabilite'] . '"></td>';

                                        if(!empty($_SESSION['listcars'][$i][0]['image'])){
                                            echo '<td>' . htmlspecialchars($_SESSION['listcars'][$i][0]['image']) . '</td>';
                                        } else {
                                            echo '<td></td>';
                                        }

                                        echo '<td><input class="mediumtext" type="text" name="newlien[' . $_SESSION['listcars'][$i][0]['idvoiture'] . ']" value="' . $_SESSION['listcars'][$i][0]['lien'] . '"></td>';

                                        echo '<td><button class="button" type="submit" name="updatecar" value="' . $_SESSION['listcars'][$i][0]['idvoiture'] . '">Update</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageCars" value="moins">Précedent</button>
                    <button type="submit" name="pageCars" value="plus">Suivant</button>
                    <button type="submit" name="pageCars">Rafraîchir</button>
                </form>

                <h2>Ajouter une ligne</h2>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Marque</th>
                        <th scope="col">Année</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Description</th>
                        <th scope="col">Dimension</th>
                        <th scope="col">Moteur</th>
                        <th scope="col">Essence</th>
                        <th scope="col">Transmission</th>
                        <th scope="col">Hybride ?</th>
                        <th scope="col">Maniabilité</th>
                        <th scope="col">Lien</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_add.php">
                            <tr>
                                <td><input class="bigtext" type="text" name="nom"></td>

                                <td><input class="mediumtext" type="text" name="marque"></td>

                                <td><input class="smalltext" type="text" name="annee"></td>

                                <td><input class="smalltext" type="text" name="prix"></td>

                                <td><input class="bigtext" type="text" name="description"></td>

                                <td><input class="mediumtext" type="text" name="dimension"></td>

                                <td><input class="mediumtext" type="text" name="moteur"></td>

                                <td><input class="mediumtext" type="text" name="essence"></td>

                                <td><input class="bigtext" type="text" name="transmission"></td>

                                <td><input class="smalltext" type="text" name="hybride"></td>

                                <td><input class="bigtext" type="text" name="maniabilite"></td>

                                <td><input class="mediumtext" type="text" name="lien"></td>
                                        
                                <td><button class="button" type="submit" name="addcar">Ajouter</button></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                <?php endif; ?>
            </section>

            <section id="pagerights">
                <?php if(isset($_SESSION['listrights'])): ?>
                <h1>Liste des droits</h1>

                <div>
                    <form method="POST" action="traitement_search.php">
                        <input type="text" class="" name="searchvalue" placeholder="Rechercher un élément...">
                        <input type="hidden" name="action" value="rights">
                    </form>
                </div>
                <br>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listrights']); $i++){
                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listrights'][$i][0]['iduser']) . '</th>';
                                        echo '<td>' . htmlspecialchars($_SESSION['listrights'][$i][0]['nomUtilisateur']) . '</td>';
                                        echo '<td>' . htmlspecialchars($_SESSION['listrights'][$i][0]['email']) . '</td>';

                                        echo '<td><input class="mediumtext" type="text" name="newstatus[' . $_SESSION['listrights'][$i][0]['iduser'] . ']" value="' . $_SESSION['listrights'][$i][0]['status'] . '"></td>'; 
                                        
                                        echo '<td><button class="button" type="submit" name="updateright" value="' . $_SESSION['listrights'][$i][0]['iduser'] . '">Update</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageRights" value="moins">Précedent</button>
                    <button type="submit" name="pageRights" value="plus">Suivant</button>
                    <button type="submit" name="pageRights">Rafraîchir</button>
                </form>
                <?php endif; ?>
            </section>

            <section id="pagequiz">
                <?php if(isset($_SESSION['listquestions']) && isset($_SESSION['listanswers'])): ?>
                <h1>Liste des questions</h1>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">Tier</th>
                        <th scope="col">Nombre d'options</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listquestions']); $i++){
                                    $nbOptions=0;
                                    for($j=0; $j<count($_SESSION['listanswers']); $j++){
                                        if($_SESSION['listanswers'][$j][0]['numeroquestion'] == $_SESSION['listquestions'][$i][0]['numero']){
                                            $nbOptions++;
                                        }
                                    }

                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listquestions'][$i][0]['numero']) . '</th>';

                                        echo '<td><input class="massivetext" type="text" name="newdescriptif[' . $_SESSION['listquestions'][$i][0]['numero'] . ']" value="' . $_SESSION['listquestions'][$i][0]['descriptif'] . '"></td>'; 

                                        echo '<td><input class="smalltext" type="text" name="newtier[' . $_SESSION['listquestions'][$i][0]['numero'] . ']" value="' . $_SESSION['listquestions'][$i][0]['tier'] . '"></td>';
                                        
                                        echo '<td>' . $nbOptions . '</td>';
                                        
                                        echo '<td><button class="button" type="submit" name="updatequestion" value="' . $_SESSION['listquestions'][$i][0]['numero'] . '">Update</button></td>';

                                        echo '<td><button class="buttonred" type="submit" name="deletequestion" value="' . $_SESSION['listquestions'][$i][0]['numero'] . '">Enlever</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageQuestions" value="moins">Précedent</button>
                    <button type="submit" name="pageQuestions" value="plus">Suivant</button>
                    <button type="submit" name="pageQuestions">Rafraîchir</button>
                </form>

                <h2>Ajouter une ligne</h2>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Question</th>
                        <th scope="col">Tier</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_add.php">
                            <tr>
                                <td><input class="massivetext" type="text" name="descriptif"></td>

                                <td><input class="smalltext" type="text" name="tier"></td>
                                        
                                <td><button class="button" type="submit" name="addquestion">Ajouter</button></td>
                            </tr>
                        </form>
                    </tbody>
                </table>

                <h1>Liste des réponses</h1>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Texte</th>
                        <th scope="col">Profil</th>
                        <th scope="col">Lié à Q#</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listanswers']); $i++){
                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listanswers'][$i][0]['idoptionrep']) . '</th>';

                                        echo '<td><input class="massivetext" type="text" name="newtexte[' . $_SESSION['listanswers'][$i][0]['idoptionrep'] . ']" value="' . $_SESSION['listanswers'][$i][0]['texte'] . '"></td>'; 

                                        echo '<td><input class="mediumtext" type="text" name="newprofil[' . $_SESSION['listanswers'][$i][0]['idoptionrep'] . ']" value="' . $_SESSION['listanswers'][$i][0]['profil'] . '"></td>';
                                        
                                        echo '<td><input class="smalltext" type="text" name="newnumeroquestion[' . $_SESSION['listanswers'][$i][0]['idoptionrep'] . ']" value="' . $_SESSION['listanswers'][$i][0]['numeroquestion'] . '"></td>'; 
                                        
                                        echo '<td><button class="button" type="submit" name="updateanswer" value="' . $_SESSION['listanswers'][$i][0]['idoptionrep'] . '">Update</button></td>';

                                        echo '<td><button class="buttonred" type="submit" name="deleteanswer" value="' . $_SESSION['listanswers'][$i][0]['idoptionrep'] . '">Enlever</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageAnswers" value="moins">Précedent</button>
                    <button type="submit" name="pageAnswers" value="plus">Suivant</button>
                    <button type="submit" name="pageAnswers">Rafraîchir</button>
                </form>

                <h2>Ajouter une ligne</h2>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Texte</th>
                        <th scope="col">Profil</th>
                        <th scope="col">Lié à Q#</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_add.php">
                            <tr>
                                <td><input class="massivetext" type="text" name="texte"></td>

                                <td><input class="mediumtext" type="text" name="profil"></td>

                                <td><input class="smalltext" type="text" name="numeroquestion"></td>
                                        
                                <td><button class="button" type="submit" name="addanswer">Ajouter</button></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                <?php endif; ?>
            </section>
            
            <section id="pagecaptcha">
                <?php if(isset($_SESSION['listcaptcha'])): ?>
                <h1>Liste des questions de Captcha</h1>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">Réponse</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listcaptcha']); $i++){
                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listcaptcha'][$i][0]['idcaptcha']) . '</th>';

                                        echo '<td><input class="massivetext" type="text" name="newquestionCaptcha[' . $_SESSION['listcaptcha'][$i][0]['idcaptcha'] . ']" value="' . $_SESSION['listcaptcha'][$i][0]['questionCaptcha'] . '"></td>'; 

                                        echo '<td><input class="mediumtext" type="text" name="newreponseCaptcha[' . $_SESSION['listcaptcha'][$i][0]['idcaptcha'] . ']" value="' . $_SESSION['listcaptcha'][$i][0]['reponseCaptcha'] . '"></td>'; 
                                        
                                        echo '<td><button class="button" type="submit" name="updatecaptcha" value="' . $_SESSION['listcaptcha'][$i][0]['idcaptcha'] . '">Update</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageCaptcha" value="moins">Précedent</button>
                    <button type="submit" name="pageCaptcha" value="plus">Suivant</button>
                    <button type="submit" name="pageCaptcha">Rafraîchir</button>
                </form>

                <h2>Ajouter une ligne</h2>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Question</th>
                        <th scope="col">Réponse</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_add.php">
                            <tr>
                                <td><input class="massivetext" type="text" name="questionCaptcha"></td>

                                <td><input class="mediumtext" type="text" name="reponseCaptcha"></td>
                                        
                                <td><button class="button" type="submit" name="addcaptcha">Ajouter</button></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                <?php endif; ?>
            </section>

            <section id="pagereports">
                <?php if(isset($_SESSION['listreports'])): ?>
                <h1>Signalements par utilisateur</h1>

                <div>
                    <form method="POST" action="traitement_search.php">
                        <input type="text" class="" name="searchvalue" placeholder="Rechercher un élément...">
                        <input type="hidden" name="action" value="reports">
                    </form>
                </div>
                <br>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Signalements</th>
                        <th scope="col">Banni ?</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="traitement_edit.php">
                            <?php
                                for($i=0; $i<count($_SESSION['listreports']); $i++){
                                    echo '<tr>';
                                        echo '<th scope="row">' . htmlspecialchars($_SESSION['listreports'][$i][0]['iduser']) . '</th>';
                                        echo '<td>' . htmlspecialchars($_SESSION['listreports'][$i][0]['nomUtilisateur']) . '</td>';
                                        echo '<td>' . htmlspecialchars($_SESSION['listreports'][$i][0]['email']) . '</td>';
                                        echo '<td>' . htmlspecialchars($_SESSION['listreports'][$i][0]['reports']) . '</td>';
                                        if($_SESSION['listreports'][$i][0]['ban'] == 0){
                                            echo '<td>Non</td>';
                                        }else{
                                            echo '<td>Oui</td>';
                                        }

                                        echo '<td><button class="button" type="submit" name="updateban" value="' . $_SESSION['listreports'][$i][0]['iduser'] . '">Update</button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </form>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageReports" value="moins">Précedent</button>
                    <button type="submit" name="pageReports" value="plus">Suivant</button>
                    <button type="submit" name="pageReports">Rafraîchir</button>
                </form>
                <?php endif; ?>
            </section>

            <section id="pagemessages">
                <h1>Contrôle des messages</h1>

                <form method="POST" action="traitement_messages.php">
                    <div class=" col-3 mb-3">
                        <label class="form-label">Date de début du contrôle :</label>
                        <input type="date" class="form-control" name="dateControl">
                    </div>
                    <button type="submit" class="btn btn-danger mb-5" name="controler">Contrôler</button>
                </form>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Contenu</th>
                        <th scope="col">Expéditeur</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($_SESSION['messages_suspects'])){ ?>
                        <?php foreach($_SESSION['messages_suspects'] as $message): ?>
                            <tr>
                                <td><?= htmlspecialchars($message['id']) ?></td>
                                <td><?= htmlspecialchars($message['date']) ?></td>
                                <td><?= htmlspecialchars($message['contenu']) ?></td>
                                <td><?= htmlspecialchars($message['expediteur']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageReports" value="moins">Précedent</button>
                    <button type="submit" name="pageReports" value="plus">Suivant</button>
                    <button type="submit" name="pageReports">Rafraîchir</button>
                </form>
            </section>

            <section id="pagemails">
                <h1>Mails automatique</h1>

                <form method="POST" action="traitement_mails.php">
                    <div class="row">
                        <div class=" col-6 mb-3">
                            <label class="form-label">Envoyer le mail aux utilisateurs dont la dernière connexion date d'avant le</label>
                        </div>
                        <div class=" col-3 mb-3">
                            <input type="date" class="form-control" name="dateLimite">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger mb-5" name="envoyer">Envoyer</button>
                    
                </form>

                <h5>Utilisateurs ayant reçus le mail</h5>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pseudo</th>
                        <th scope="col">email</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($_SESSION['utilisateurs_concernes'])){ ?>
                        <?php foreach($_SESSION['utilisateurs_concernes'] as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['nom']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>

                <form method="POST" action="traitement_offset.php">
                    <button type="submit" name="pageReports" value="moins">Précedent</button>
                    <button type="submit" name="pageReports" value="plus">Suivant</button>
                    <button type="submit" name="pageReports">Rafraîchir</button>
                </form>
            </section>

        </div>
    </main> 
</body>
<?php else: ?>
<body>
    <header>
        <img src="image/logo1.png" alt="logo CarMate" width="225px">
    </header>
    <main class="main-connexion">
        <br><br><br>
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow p-4">
                <div class="card-body">
                    <h1 class="text-center mb-4">Se connecter</h1>

                    <form method="POST" action="traitement_connexion.php">
                    <div class="mb-3">
                        <label class="form-label">Nom d'utilisateur</label>
                        <input class="form-control" type="text" name="username">
                        <div class="invalid-feedback d-block">
                        <?php echo $errors['username'] ?? ''; ?>
                        </div> 
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input class="form-control" type="password" name="password">
                        <div class="invalid-feedback d-block">
                        <?php echo $errors['password'] ?? ''; ?>
                        </div> 
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="connection" id="button-connexion" class="btn btn-primary">Se connecter</button>
                    </div>
                    </form>

                </div>
                </div>
            </div>
            </div>
        </div>
    </main>
</body>
<?php endif; ?>
</html>