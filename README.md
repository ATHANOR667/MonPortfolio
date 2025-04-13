# MonPortfolio - Application de Portfolio Personnel

## À propos du projet

MonPortfolio est une application web développée avec Laravel 12 et PHP 8.3 qui permet de créer et gérer un portfolio professionnel en ligne. L'application offre une interface publique pour les visiteurs et une interface d'administration sécurisée pour gérer le contenu.

## Fonctionnalités principales

- **Interface publique** : Présentation des projets, parcours professionnel et formulaire de contact
- **Interface d'administration** : Gestion complète du contenu (projets, catégories, profil, etc.)
- **Système d'authentification sécurisé** : Connexion administrateur avec options de sécurité avancées
- **Gestion des projets** : Ajout, modification et suppression de projets avec images
- **Gestion du profil** : Édition des informations personnelles, expériences et formations
- **Système de contact** : Formulaire de contact avec notifications par email
- **Design responsive** : Interface adaptée à tous les appareils (mobile, tablette, desktop)

## Structure du projet

### Architecture MVC

Le projet suit l'architecture MVC (Modèle-Vue-Contrôleur) de Laravel :

- **Modèles** (`app/Models/`) : Définissent la structure des données et les relations
- **Vues** (`resources/views/`) : Templates Blade pour l'affichage
- **Contrôleurs** (`app/Http/Controllers/`) : Gèrent la logique métier

### Principaux dossiers

- `app/Http/Controllers/Admin/` : Contrôleurs pour l'interface d'administration
- `app/Http/Controllers/` : Contrôleurs pour l'interface publique
- `app/Models/` : Modèles de données (User, Project, Category, etc.)
- `app/Mail/` : Classes pour l'envoi d'emails
- `resources/views/admin/` : Vues de l'interface d'administration
- `resources/views/auth/` : Vues d'authentification
- `resources/views/emails/` : Templates d'emails
- `resources/views/layouts/` : Layouts principaux (app, admin)
- `public/` : Fichiers accessibles publiquement (CSS, JS, images)
- `routes/web.php` : Définition des routes de l'application

### Modèles principaux

- `User` : Utilisateurs administrateurs
- `Project` : Projets du portfolio
- `Category` : Catégories de projets
- `Profile` : Informations du profil
- `Experience` : Expériences professionnelles
- `Education` : Formations
- `Comment` : Commentaires sur les projets
- `Contact` : Messages de contact
- `Visitor` : Statistiques de visite

## Système d'authentification

Le système d'authentification de l'interface d'administration a été importé d'un autre projet et adapté pour correspondre à la charte graphique et à la structure des vues du projet actuel.

### Fonctionnalités de sécurité

- Connexion administrateur
- Réinitialisation de mot de passe
- Réinitialisation d'email
- Suppression des identifiants par défaut
- Vérification par code OTP

## Emails du système

L'application utilise plusieurs templates d'emails :

1. `emails/contact-confirmation.blade.php` : Confirmation envoyée à l'utilisateur après soumission du formulaire de contact
2. `emails/contact-notification.blade.php` : Notification envoyée à l'administrateur lors d'un nouveau message de contact
3. `emails/contact-reply.blade.php` : Réponse à un message de contact
4. `Mail/otp.blade.php` : Email contenant le code OTP pour la vérification

## Design responsive

L'interface utilisateur est entièrement responsive grâce à Tailwind CSS. Des optimisations spécifiques ont été apportées pour :

- Les barres de navigation (admin et invité)
- L'affichage des éléments sur différentes largeurs d'écran
- La prévention de l'affichage des pages avant le chargement complet des éléments

## Installation et configuration

### Prérequis

- PHP 8.3 ou supérieur
- Composer
- SQLite (ou autre base de données supportée par Laravel)

### Installation

1. Cloner le dépôt
2. Installer les dépendances : `composer install`
3. Copier le fichier d'environnement : `cp .env.example .env`
4. Générer la clé d'application : `php artisan key:generate`
5. Configurer la base de données dans le fichier `.env`
6. Exécuter les migrations : `php artisan migrate`
7. Exécuter les seeders : `php artisan db:seed`
8. Démarrer le serveur : `php artisan serve`

## Utilisation

### Interface publique

Accessible à l'URL racine du site, elle permet aux visiteurs de :
- Consulter les projets
- Voir le parcours professionnel
- Envoyer un message via le formulaire de contact

### Interface d'administration

Accessible à l'URL `/admin`, elle permet à l'administrateur de :
- Gérer les projets et catégories
- Éditer le profil, les expériences et formations
- Gérer les messages de contact
- Accéder aux statistiques de visite
- Configurer les paramètres de sécurité

## Améliorations apportées

1. Adaptation des vues d'authentification à la charte graphique du projet
2. Création d'une route de sécurité pour le menu administrateur
3. Création de templates pour tous les emails du système
4. Optimisation du responsive design, particulièrement pour les barres de navigation
5. Restructuration des routes pour une meilleure organisation
6. Prévention de l'affichage des pages avant le chargement complet des éléments

## Technologies utilisées

- **Backend** : Laravel 12, PHP 8.3
- **Frontend** : Tailwind CSS, Alpine.js
- **Base de données** : SQLite (configurable)
- **Autres** : Livewire pour certains composants interactifs
