<?php include('includes/traitement_deco_auto.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    $pageTitle = 'CarMate — Accueil';
    include('includes/head.php');
    unset($_SESSION['saisi']);
    include('includes/choix_theme.php');

    include('includes/reinitialisation_infos_quiz.php');

    unset($_SESSION['formulaire']);
?>
<body style="<?php if(isset($_SESSION['iduser'])):if($themeSombreClair == 0):?>background-color:rgb(89, 89, 89)   ;<?php endif;endif; ?>">
    <?php include('includes/header.php');?>
    <main>
        <div class="image-container">
            <img src="image/fond_1.png" width="100%">
            <div class="part1">
                <h1>Trouvez votre voiture idéale !</h1>
                <div class="line2"></div>
                <p>En quelques clics, trouvez la voiture la plus adaptée à votre personnalité et votre rythme de vie.</p>
                <a href="voiture.php">
                    <button type="button" class="btn" style="--bs-btn-padding-y: 1rem; --bs-btn-font-size: 1rem; width:300px">
                        Commencer
                    </button>
                </a>
            </div>
        </div>
        <div class="fond-popular">
            <div class="text-popular">
                <h1>Le concept CarMate</h1>
                <div class="line2"></div>
                <p class="textIndex"><strong>Carmate est plus qu'un simple site web, c'est une réelle communauté de passionnés du monde automobile !</strong></p>
                <p class="textIndex">Sur CarMate vous pouvez :<br><br>- Trouver la voiture de vos rêves en répondant à un quiz adapté à vous et à votre personnalité et rythme de vie ou en piochant une aléatoirement<br>- Acheter des accessoires ou des pièces détachées pour votre véhicule<br>- Discuter avec d'autres utilisateurs CarMate de votre passion commune sur le forum général ou via une discussion privée<br>- Trouver des événements automobiles variés qui vous intérressent<br>- Poser des questions diverses à notre CarBot<br><br><br><strong>Le tout dans une ambiance conviviale et personnalisée selon vos goûts !</strong></p>
            </div>
        </div>

        <div class="part2">
            <h1>Gardez l'esprit ouvert !</h1>
            <div class="line2"></div>
            <p>Envie de découvrir de nouvelles voitures ? Cliquez sur ce bouton et laissez vous surpendre par une voiture piochée aléatoirement !</p>
            <div class="fond-button">
                <a href="voiture_aleatoire.php" target="_blank"><button type="button" class="red-circle-button"></button></a>
            </div>
        </div> 
        <div class="part2">
            <h1>Les dernières actualités</h1>
            <div class="line2"></div>
            <p>CarMate vous présente les dernières actualités du monde automobile : prochaines sorties, innovations, événements et bien plus encore.</p>
            <div class="news-tab row">
                <div class="news-card1 col-12 col-md-4">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="https://www.automobile-magazine.fr/toute-l-actualite/article/47020-a-quel-moment-la-pub-automobile-est-passee-de-la-consommation-dune-voiture-a-son-autonomie" target="_blank">
                                    <img src="image/actuCar_1.png" class="d-block w-100" alt="actuCarroussel">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>À quel moment la pub automobile est passée de la consommation d'une voiture… à son autonomie ?</p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://www.automobile-magazine.fr/nouveautes/article/47001-kia-presente-son-suv-electrique-le-plus-accessible-mais-ne-foncez-pas-chez-le-concessionnaire" target="_blank">
                                    <img src="image/actuCar_2.png" class="d-block w-100" alt="actuCarroussel">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>Kia présente son SUV électrique le plus accessible… mais ne foncez pas chez le concessionnaire</p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                            <a href="https://www.automobile-magazine.fr/tous-les-essais/article/46931-essai-ferrari-12cilindri-spider-au-volant-dun-des-derniers-v12-de-la-planete" target="_blank">
                                <img src="image/actuCar_3.png" class="d-block w-100" alt="actuCarroussel">
                                <div class="carousel-caption d-none d-md-block">
                                    <p>Essai Ferrari 12Cilindri Spider : au volant d'un des derniers V12 de la planète.</p>
                                </div>
                            </a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="news-card2">
                        <a href="https://www.auto-moto.com/business/voitures-les-plus-volees-en-2024-des-assurances-autos-jusqua-16-plus-cher-54244" target="_blank">
                            <img src="image/actu1.png" alt="actu1">
                            <p>Voitures les plus volées en 2024 : des assurances autos jusqu'à 16% plus cher</p>
                        </a>
                    </div>
                    <div class="news-card2">
                        <a href="https://www.autoplus.fr/actualite/insolite/vente-corvette-c1-legendaire-1-euro-1369736.html" target="_blank">
                            <img src="image/actu2.png" alt="actu2">
                            <p>Il met en vente une Corvette C1 légendaire pour seulement 1 € !</p>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="news-card3">
                        <a href="https://www.autoplus.fr/environnement/voiture-hybride/ce-suv-hybride-prometteur-offre-une-autonomie-electrique-record-de-200-km-1369550.html" target="_blank">
                            <img src="image/actu3.png" alt="actu3">
                            <p>Ce SUV hybride prometteur offre une autonomie électrique record</p>
                        </a>
                    </div>
                    <div class="news-card3">
                        <a href="https://www.auto-moto.com/high-tech/tesla-accelere-pour-la-conduite-autonome-en-chine-54103" target="_blank">
                            <img src="image/actu4.png" alt="actu4">
                            <p>Tesla accélère pour la conduite autonome en Chine</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>  
    </main>
    <?php include('includes/footer.php');
    include('includes/lien_chatbot.php');
    ?>
</body>
</html>