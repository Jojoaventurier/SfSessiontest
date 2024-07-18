Ce projet est une application web permettant d'afficher, créer et supprimer des sessions de formations. Chaque session inclut un ensemble de modules, pouvant varier en durée selon les sessions proposées. Les utilisateurs peuvent inscrire ou désinscrire des stagiaires aux sessions de formations. Une interface utilisateur est mise en place pour que seules les personnes avec un rôle d'administrateur puissent effectuer des modifications, tandis qu'un utilisateur normal peut seulement consulter les sessions de formation.

    Objectifs du Projet
    Modélisation des relations entre les entités du projet.
    Création d'un projet Symfony.
    Création et manipulation des entités.
    Mise en place d'un CRUD pour les entités Session et Stagiaire.
    Implémentation d'une interface utilisateur et administrateur.
    Utilisation de Doctrine et DQL pour les requêtes vers la base de données.


Fonctionnalités

  Sessions de Formations :
  
    Affichage des sessions de formations.
    Création de nouvelles sessions.
    Suppression des sessions existantes.
    Chaque session inclut différents modules.
    Les modules peuvent avoir des durées variables selon les sessions.
    
  Gestion des Stagiaires :

    Inscription des stagiaires aux sessions de formations.
    Désinscription des stagiaires des sessions de formations.
    
  Interface Utilisateur :

    Consultation des sessions de formations pour les utilisateurs normaux.
    Modifications des sessions et gestion des stagiaires réservées aux administrateurs.
    
  CRUD :

    Création, lecture, mise à jour et suppression des entités Session et Stagiaire.
    
  Technologies Utilisées :

    Symfony pour le framework web.
    Doctrine pour la gestion des entités et des requêtes DQL.

    
Cette application offre une gestion complète des sessions de formations, avec un contrôle d'accès basé sur les rôles des utilisateurs. Elle facilite la gestion des stagiaires et des modules de formation, tout en fournissant une interface conviviale et sécurisée pour les administrateurs.
