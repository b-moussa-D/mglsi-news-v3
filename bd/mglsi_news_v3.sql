CREATE DATABASE IF NOT EXISTS mglsi_news_v3;
USE mglsi_news_v3;

CREATE TABLE Categorie (
  id INT PRIMARY KEY AUTO_INCREMENT,
  libelle VARCHAR(100) NOT NULL
);

CREATE TABLE Utilisateur (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  login VARCHAR(50) UNIQUE NOT NULL,
  motDePasse VARCHAR(255) NOT NULL,
  role ENUM('editeur','administrateur') NOT NULL DEFAULT 'editeur'
);

CREATE TABLE Article (
  id INT PRIMARY KEY AUTO_INCREMENT,
  titre VARCHAR(255) NOT NULL,
  extrait VARCHAR(400),
  contenu TEXT,
  dateCreation DATETIME DEFAULT NOW(),
  categorie INT,
  auteur INT,
  CONSTRAINT fk_categorie_article FOREIGN KEY (categorie) REFERENCES Categorie(id),
  CONSTRAINT fk_auteur_article FOREIGN KEY (auteur) REFERENCES Utilisateur(id)
);

CREATE TABLE Token (
  id INT PRIMARY KEY AUTO_INCREMENT,
  jeton VARCHAR(64) UNIQUE NOT NULL,
  utilisateur INT NOT NULL,
  dateCreation DATETIME DEFAULT NOW(),
  actif TINYINT(1) DEFAULT 1,
  CONSTRAINT fk_utilisateur_token FOREIGN KEY (utilisateur) REFERENCES Utilisateur(id)
);

-- Jeu de donnees de test
-- IMPORTANT : les hash ci-dessous sont des exemples/placeholders.
-- Genere les vrais hash en PHP avec : echo password_hash("motdepasse", PASSWORD_DEFAULT);
-- puis remplace les valeurs avant d'importer ce fichier.
INSERT INTO Categorie (libelle) VALUES ('Sport'),('Politique'),('Éducation'),('Économie');

INSERT INTO Utilisateur (nom, prenom, login, motDePasse, role) VALUES
('Diongue','Baye Moussa','bmoussa', '$2y$10$exempleHacheAGenererAvecPasswordHash', 'administrateur'),
('Diallo','Papa Amady','pamady', '$2y$10$exempleHacheAGenererAvecPasswordHash', 'editeur'),
('Samb','Koumba','ksamb', '$2y$10$exempleHacheAGenererAvecPasswordHash', 'editeur');
