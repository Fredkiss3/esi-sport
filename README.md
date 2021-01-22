#ESI-SPORT

Il s'agit d'un site de magazine sportif.

### Pré-requis

- avoir  `composer` installé
- avoir  `php >= 7.2` installé
- avoir `MySQL >= 5.0` installé

###Comment lancer le projet

Pour lancer l'application il faut : 

1- installer les dépendances 

```bash
composer install 
```

2- Mettre en place la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

3- Lancer le serveur

```bash
php -S localhost:8000 -t public
```

4- Ouvrir le navigateur à l'adresse http://localhost:8000

