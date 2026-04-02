# 🏎️ CarMate - Site Fullstack pour Passionnés d'Auto

**CarMate** est une plateforme web complète conçue pour rassembler la communauté automobile. Le projet inclut un site utilisateur riche en fonctionnalités et un backoffice dédié à l'administration et à la modération.

## 🌟 Fonctionnalités principales

### 👤 Espace Utilisateur
- **Système d'Authentification** : Inscription avec captcha, vérification par mail et réinitialisation de mot de passe.
- **Profil Personnalisable** : Création d'un avatar modulaire (tête, lunettes, chapeau) et gestion des informations personnelles.
- **Voiture Idéale** : Un quiz algorithmique qui détermine le type de véhicule adapté à votre profil.
- **Le Garage (Marketplace)** : Système de petites annonces pour acheter/vendre des pièces avec paiement sécurisé via Stripe.
- **Événements** : Création, recherche (avec filtres) et inscription à des rassemblements automobiles.
- **Forum & Messagerie** : Chat général en temps réel et système de discussions privées entre membres.
- **CarBot** : Un chatbot intégré pour aider les utilisateurs dans leur navigation.

### 🛠️ Backoffice (Administration)
- **Dashboard** : Statistiques de connexion et vue d'ensemble du site.
- **Modération** : Gestion des signalements (reports), bannissement des utilisateurs et contrôle des messages via une blacklist.
- **Gestion de contenu** : Ajout/Modification des voitures du catalogue, des questions du quiz et des captchas.
- **Marketing** : Relance automatique par mail pour les utilisateurs inactifs.

## 🚀 Installation rapide

### 1. Prérequis
- Un serveur local (MAMP, WAMP, XAMPP ou Laragon).
- PHP 7.4 ou supérieur.
- MySQL.

### 2. Base de données
1. Créez une base de données nommée `projetannuel` (ou celle configurée dans vos fichiers `db.php`).
2. Importez le fichier SQL de structure (celui que nous avons généré ensemble) pour créer les tables.
3. (Optionnel) Importez le script de "Seed" pour avoir des données de test (utilisateurs, voitures, quiz).

### 3. Configuration
- Modifiez les fichiers `includes/db.php` et `Backoffice/includes/db.php` avec vos identifiants de connexion MySQL.
- Pour les fonctionnalités d'envoi de mails (PHPMailer) et de paiement (Stripe), assurez-vous d'avoir une connexion internet et les clés API valides dans les fichiers correspondants (`traitement_inscription.php`, `checkout.php`).

## 🛠️ Technologies utilisées

- **Frontend** : HTML5, CSS3, JavaScript (Vanilla), Bootstrap 5.
- **Backend** : PHP (Architecture procédurale et inclusion de composants).
- **Base de données** : MySQL.
- **Librairies tierces** : 
    - [PHPMailer](https://github.com/PHPMailer/PHPMailer) (Envoi de mails).
    - [Stripe API](https://stripe.com/docs/api) (Paiement en ligne).
    - [jsPDF](https://github.com/parallax/jsPDF) (Génération de factures et détails d'événements).

## 👥 Auteurs
Projet réalisé par :
- **Ali JAHMI** — Développement, design et gestion de projet.
- **Thomas LARGE** — Développement, design et gestion de projet.
- **Roland FERT** — Développement, design et gestion de projet.

---
*Projet réalisé dans un cadre académique (ESGI).*
