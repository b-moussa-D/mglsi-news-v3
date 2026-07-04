# MGLSI News V3

Projet du cours d'Architecture Logicielle — **Groupe 7**, Master 1 GLSI, ESP/UCAD.

Site d'actualité avec trois profils utilisateurs (visiteur, éditeur, administrateur), un service web SOAP (gestion des utilisateurs), un service web REST (consultation des articles), et une application cliente Java pour la gestion des utilisateurs.

## Équipe

| Membre              | Rôle                            |
| ------------------- | ------------------------------- |
| Baye Moussa Diongue | Chef de projet — Site Web (MVC) |
| Papa Amady Diallo   | Services Web (SOAP + REST)      |
| Koumba Samb         | Application Client Java         |

## Architecture

mglsi-news-v3/
 ├── bd/                    Schéma SQL + données de test
 ├── config/                Connexion PDO à la base
 ├── app/
 │   ├── models/            Article, Categorie, Utilisateur, Token
 │   ├── controllers/       ArticleController, AuthController, AdminController
 │   └── views/             Vues du site (layouts, articles, admin, auth)
 ├── public/                Front controller (index.php) et assets (css)
 ├── services/soap/         Service SOAP (gestion des utilisateurs)
 ├── api/rest/               Service REST (consultation des articles)
 ├── client/src/            Application cliente Java
 └── bd/mglsi_news_v3.sql

Le site et les services web partagent la même couche `app/models/` et la même base de données — c'est le contrat commun entre les trois modules.

## Installation

### Prérequis

- XAMPP (Apache + MySQL/MariaDB + PHP 8+)
- L'extension PHP **`soap`** activée (voir ci-dessous — nécessaire pour le service SOAP)
- Java JDK 11+ (pour l'application cliente)
- Git

### 1. Cloner le dépôt

Placer le dossier **directement dans `htdocs`** pour qu'Apache puisse le servir :

```bash
cd C:\xampp\htdocs
git clone https://github.com/b-moussa-D/mglsi-news-v3.git
cd mglsi-news-v3
git checkout develop
git pull origin develop
```

### 2. Activer l'extension SOAP (indispensable)

Sans cette étape, le service SOAP renvoie l'erreur `Fatal error: Class "SoapServer" not found`.

1. Dans le panneau de contrôle XAMPP, à côté d'Apache : **Config → PHP (php.ini)**.
2. Cherche la ligne `;extension=soap` et enlève le point-virgule : `extension=soap`.
3. Enregistre, puis **redémarre Apache** (arrêt + démarrage, pas juste enregistrer le fichier).

### 3. Importer la base de données

Dans phpMyAdmin, onglet **Importer**, sélectionne `bd/mglsi_news_v3.sql`. Cela crée la base `mglsi_news_v3` avec les tables `Categorie`, `Utilisateur`, `Article`, `Token`, et 3 comptes de test.

### 4. Démarrer Apache et MySQL

Depuis le panneau de contrôle XAMPP.

## Comptes de test

| Login     | Mot de passe    | Rôle           |
| --------- | --------------- | -------------- |
| `bmoussa` | `motdepasse123` | administrateur |
| `pamady`  | `motdepasse123` | éditeur        |
| `ksamb`   | `motdepasse123` | éditeur        |

## Points d'accès

| Module                                | URL                                                          |
| ------------------------------------- | ------------------------------------------------------------ |
| Site web                              | `http://localhost/mglsi-news-v3/public/index.php?action=accueil` |
| Connexion                             | `http://localhost/mglsi-news-v3/public/index.php?action=login` |
| Service REST — tous les articles      | `http://localhost/mglsi-news-v3/api/rest/articles.php?format=json` (ou `format=xml`) |
| Service REST — articles par catégorie | `http://localhost/mglsi-news-v3/api/rest/articles_par_categorie.php?categorie=1&format=json` |
| Service SOAP                          | `http://localhost/mglsi-news-v3/services/soap/soap_server.php` (point d'entrée POST, ne pas visiter en GET) |

## Fonctionnalités

- **Visiteur** : liste paginée des articles, détail d'un article, filtrage par catégorie.
- **Éditeur** (après connexion) : gestion (ajout/modification/suppression) des articles et des catégories.
- **Administrateur** (après connexion) : en plus des droits éditeur, gestion des utilisateurs et génération de jetons d'authentification pour l'accès aux services web restreints.

## Stratégie Git

Travail en branches `feature/...`, jamais directement sur `main`. Intégration continue sur `develop`, livraison finale sur `main` avec un tag de version.

main
 └── develop
 ├── feature/bd-modele
 ├── feature/site-web-visiteur
 ├── feature/site-web-auth-roles
 ├── feature/site-web-crud
 ├── feature/soap-utilisateurs
 ├── feature/rest-articles
 └── feature/client-java

```
## Application cliente Java

Dans `client/src/`. Se connecte au service SOAP via des enveloppes HTTP construites directement (pas de génération de stubs). Voir `SoapClient.java`, `LoginFrame.java`, `UtilisateurFrame.java`.

## Problèmes connus

- L'extension PHP `soap` n'est pas activée par défaut sur beaucoup d'installations XAMPP Windows — voir l'étape 2 de l'installation.
- Les mots de passe de test sont tous identiques (`motdepasse123`) pour simplifier les tests en équipe ; à ne pas utiliser en production.
```
