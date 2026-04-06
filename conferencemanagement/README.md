# 🎓 Système de Gestion de Conférences Académiques

Ce projet est une plateforme complète de gestion de conférences (type CMT/EasyChair), développée avec **Laravel**. Elle permet d'automatiser tout le cycle de vie d'un événement scientifique, de la soumission des articles à la décision finale.

## 🚀 Fonctionnalités principales

L'application gère trois types d'utilisateurs avec des workflows distincts :

* **Auteurs :** Soumission d'articles, suivi de l'état (en attente, accepté, rejeté).
* **Comité de programme (PC Members) :** Évaluation des articles assignés, saisie des notes et commentaires.
* **Chairs (Organisateurs) :** * Configuration de la conférence.
    * Invitation des membres du comité (PC Members).
    * Attribution des articles aux réviseurs.
    * Prise de décision finale basée sur les évaluations.
    * Envoi automatique de notifications par email.

## 🛠 Stack Technique

* **Framework :** Laravel 10+
* **Langage :** PHP 8.x
* **Base de données :** MySQL (Modélisation UML complexe avec classes d'association)
* **Frontend :** Blade Templates & Tailwind CSS
* **Authentification :** Laravel Breeze / Fortify

## 📦 Installation et Configuration

Pour faire fonctionner ce projet localement :

1. **Cloner le projet :**
   ```bash
   git clone [https://github.com/AbdelhamidRb/conference_management.git](https://github.com/AbdelhamidRb/conference_management.git)
   cd conference_management
