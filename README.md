# [PHP] - P6 Openclassrooms - Développez de A à Z le site communautaire SnowTricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/38908a1ea0204cd39996400db31ba8eb)](https://www.codacy.com/manual/thomas-claireau/PHP-P6-Openclassrooms?utm_source=github.com&utm_medium=referral&utm_content=thomas-claireau/PHP-P6-Openclassrooms&utm_campaign=Badge_Grade)

[![Maintainability](https://api.codeclimate.com/v1/badges/56882df21a146f2e28bf/maintainability)](https://codeclimate.com/github/thomas-claireau/PHP-P6-Openclassrooms/maintainability)

Démo du projet, [c'est par ici 👋](http://snowtricks.thomas-claireau.fr/)

## Installation du projet

Via Composer :

```text
composer create-project thomas-claireau/snowtricks:dev-master
```

Dans le cas où vous téléchargez directement le projet (ou encore avec `git clone`), effectuez un `composer install` à la racine du projet.

Installez ensuite les dépendances front du projet. Placez-vous à la racine du projet :

```text
npm install
```

### Remarque

#### Accès base de données

Le projet est livré sur Packagist sans base de données. Cela signifie qu'il faut que vous ajoutiez votre configuration, dans le fichier `.env`, dans la partie `DATABASE_URL`.

#### Injection SQL et structure du projet

Pour obtenir une structure similaire à mon projet au niveau de la base de données, je vous joins aussi dans le dossier `~src/Migrations/` les versions de migrations que j'ai utilisées. Vous pouvez donc recréer la base de données en effectuant la commande suivante, à la racine du projet :

```text
php bin/console doctrine:migrations:migrate
```

Après avoir créer votre base de données, vous pouvez également injecter un jeu de données en effectuant la commande suivante :

```text
php bin/console doctrine:fixtures:load
```

### Lancer le projet

A la racine du projet :

-   Pour lancer le serveur de développement, effectuez un `npm run dev-server`.
-   Pour lancer le serveur de symfony, effectuez un `php bin/console server:run`.

### Site en production

Pour voir une version du site en production, suivez l'[url suivante](http://snowtricks.thomas-claireau.fr/).

### Envoi des mails

Si vous souhaitez utiliser un serveur de mail afin d'envoyer des mails, vous pouvez le configurer dans le fichier `.env` à la racine du projet, dans la partie `MAILER_URL`

Sachez que vous pouvez aussi utiliser [maildev](https://www.npmjs.com/package/maildev) pour simuler l'envoi des mails.

## Contexte

Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaitre ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Pour ce projet, nous allons nous concentrer sur la création technique du site pour Jimmy.

## Description du besoin

Vous êtes chargé de développer le site répondant aux besoins de Jimmy. Vous devez ainsi implémenter les fonctionnalités suivantes :

-   un annuaire des figures de snowboard. Vous pouvez vous inspirer de la liste des figures sur Wikipédia. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes ;
-   la gestion des figures (création, modification, consultation) ;
-   un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :

-   la page d’accueil où figurera la liste des figures ;
-   la page de création d'une nouvelle figure ;
-   la page de modification d'une figure ;
-   la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).

## Nota Bene

Il faut que les URLs de page permettent une compréhension rapide de ce que la page représente et que le référencement naturel soit facilité.

L’utilisation de bundles tiers est interdite sauf pour les données initiales, vous utiliserez les compétences acquises jusqu’ici ainsi que la documentation officielle afin de remplir les objectifs donnés.

Le design du site web est laissé complètement libre, attention cependant à respecter les wireframes fournis pour le gabarit de vos pages. Néanmoins il faudra que le site soit consultable aussi bien sur un ordinateur que sur mobile (téléphone mobile, tablette, phablette…).

En premier lieu il vous faudra écrire l’ensemble des issues/tickets afin de découper votre travail méthodiquement et vous assurer que l’ensemble du besoin client soit bien compris avec votre mentor. Les tickets/issues seront écrits dans un repository Github que vous aurez créé au préalable.

L’ensemble des figures de snowboard doivent être présentes à l’initialisation de l’application web. Vous utiliserez un bundle externe pour charger ces données.

## ✔️ Projet validé

Commentaire de l'évaluateur :

1. Évaluation globale du travail réalisé par l’étudiant (en spécifiant les critères non-validés si le projet est à retravailler) :

Thomas a produit des livrables vraiment de top qualité. Le code est propre, bien commenté, les fonctionnalités attendues sont là et quelques extras sont appréciables.

Au niveau de la présentation orale, les temps dédiés à chaque partie n'ont pas été respectés. Thomas a consacré beaucoup trop de temps à la démonstration, ce qui fait que des points comme l'estimation des tâches ou l'exécution des tests unitaires ont été vus dans les Q/R alors qu'ils auraient du faire partie de la présentation initiale.

2. Évaluation des livrables selon les critères du projet :

Les livrables sont au top. On a une bonne gestion des modèles, des controllers, et des repository. Toutes les fonctionnalités de Symfony sont utilisées avec justesse et pertinence.

La partie Git est bien fournie, et cet outil de versioning est très bien utilisé.

On regrettera que les tests unitaires soient là "parce qu'il en faut" plutôt qu'avoir de vrais tests unitaires pertinents.

3. Évaluation de la présentation orale et sa conformité aux attentes :

Thomas a passé trop de temps a faire la démonstration de l'application, entrant dans des détails non nécessaires (oubli de mot de passe, ...). Ceci lui a porté préjudice sur les deux autres parties qui n'ont pas été traitées de manière exhaustive.

Toutefois, ces points ont été abordés lors des Q/R, et Thomas a à chaque fois apporté des réponses pertinentes.

4. Évaluation des nouvelles compétences acquises par l'étudiant :

Symfony
Doctrine
Codacy
Tests unitaires
5. Points positifs (au moins 1) :

Utilisation vraiment poussée des fonctionnalités de GitHub
Code très propre et bien documenté
Séparation des différentes parties du code en utilisant des Repository
Bonne gestion d'Ajax
6. Axes d'amélioration (au moins 1) :

Tests unitaires pas très pertinents
Temps dédié à chaque partie de la présentation non respecté
