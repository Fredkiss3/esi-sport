![Build Status](https://github.com/Fredkiss3/esi_sport/workflows/PHP%20Composer/badge.svg?branch=main)

# ESI-SPORT

![ScreenShot](screenshot.png)

Il s'agit d'un site de magazine sportif.

### Pré-requis

Pour pouvoir lancer le projet il faut : 

- Installer [docker](https://docs.docker.com/engine/install/) 
- Installer  [docker-compose](https://docs.docker.com/compose/install/)
- avoir `composer` installé
- avoir `php >= 7.2` installé
- avoir `MySQL >= 5.0` installé

### Comment lancer le projet

Pour lancer l'application il faut : 

1- installer les dépendances :

```bash
composer install 
```

2- Mettre en place la base de données :

Modifier le fichier `.env` pour correspondre à votre base de données 

```dotenv
DATABASE_URL="mysql://{utitisateur}:{mot_de_passe}@127.0.0.1:3306/{base_de_données}"
```

Installer la Base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

3- Lancer le serveur :

```bash
docker-compose up -d            # pour activer le cache redis
php -S localhost:8000 -t public # pour lancer le serveur PHP
```

4- Pour générer des données par défaut vous pouvez effectuer la commande : 

```bash
php bin\console hautelook:fixtures:load
```


5- Ouvrir le navigateur à l'adresse http://localhost:8000

# Infos additionnelles

Ce projet a été conçu en suivant le modèle du Test Driven Développement.
Vous pouvez lancer les test avec la commande :

```bash
php bin/phpunit
```
