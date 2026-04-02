<?php
session_start();
?>
<header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <a href="index.php">
                    <img src="image/logo1.png" alt="logo CarMate" width="225px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="voiture.php">Ma voiture idéale</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="garage.php">Le garage</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="forum.php">Forum</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="event.php">Événements</a>
                    </li>

                    <div class="line1"></div>

                    <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tableau de bord
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" style="margin-left: 10px;">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (isset($_SESSION['iduser'])): ?>
                            <li><a class="dropdown-item" href="profil.php">Mon profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">FAQ</a></li>
                            <li><a class="dropdown-item" href="#">Langue</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="deconnexion.php">Se déconnecter</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="connexion.php">Se connecter</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">FAQ</a></li>
                            <li><a class="dropdown-item" href="#">Langue</a></li>
                        <?php endif; ?>
                    </ul>          
                </ul>
                </div>
            </div>
        </nav>
    </header>