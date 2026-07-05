# MGLSI News V3

Projet du cours d'Architecture Logicielle - Groupe 7, Master 1 GLSI, ESP/UCAD.

Site d'actualité en PHP (architecture MVC) avec trois profils (visiteur, éditeur,
administrateur), un service web SOAP pour la gestion des utilisateurs, un service
REST pour la consultation des articles, et une application cliente Java.

## Groupe

- Baye Moussa Diongue - Site web (MVC)
- Papa Amady Diallo - Services web (SOAP + REST)
- Koumba Samb - Application cliente Java

## Installation

1. Cloner le dépôt dans htdocs (XAMPP) :
   git clone https://github.com/b-moussa-D/mglsi-news-v3.git

2. Activer l'extension `soap` dans php.ini (elle est désactivée par défaut sur
   XAMPP Windows), sinon le service SOAP renvoie une erreur "Class SoapServer
   not found". Redémarrer Apache après.

3. Importer `bd/mglsi_news_v3.sql` dans phpMyAdmin.

4. Démarrer Apache et MySQL.

## Comptes de test

- bmoussa / motdepasse123 (administrateur)
- pamady / motdepasse123 (éditeur)
- ksamb / motdepasse123 (éditeur)

## Accès

- Site : http://localhost/mglsi-news-v3/public/index.php?action=accueil
- REST : http://localhost/mglsi-news-v3/api/rest/articles.php?format=json
- SOAP : http://localhost/mglsi-news-v3/services/soap/soap_server.php

## Organisation du code

- `app/models/` : accès aux données (Article, Categorie, Utilisateur, Token)
- `app/controllers/` et `app/views/` : le site (MVC)
- `services/soap/` et `api/rest/` : les services web
- `client/src/` : l'application Java

## Git

Travail en branches feature/, intégration sur develop, version finale taguée
v3.0 sur main.
