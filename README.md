# Cuistock

## Description

Cuistock est une petite application de recettes de cuisine. Elle permet de récupérer des recettes depuis l'API Spoonacular (les 100 premières à partir d'un ingredient) et de les enregistrer dans une base de données. Les recettes enregistrées peuvent être consultées.
C'est surtout un projet pour m'entraîner à l'utilisation du framework Berlioz.

Stack technique :
- Berlioz
- Hector
- Bootstrap 5 😓
- MySQL
- Sass

## Prérequis

- PHP 8
- Composer
- MySQL
- npm

## Installation

Cloner le projet :
```bash
$ git clone https://github.com/Fl0-dev/BerliozCuistock.git
```

Installer les dépendances PHP :
```bash
$ composer install
```

Installer les dépendances JS :
```bash
$ npm install
$ npm run build
```

Il faut ensuite créer une base de données MySQL et renseigner les informations de connexion dans un fichier à créer `hector.json` dans le dossier `config` :
```json
{
    "hector": {
        "dsn": "mysql:dbname=[DB_NAME];host=127.0.0.1;port=3306;charset=UTF8;user=[DB_USERNAME];password=[DB_PASSWORD]",
        "schemas": [
            "[DB_NAME]"
        ]
    }
}
```

Il faut ensuite créer les tables de la base de données en prenant les requêtes SQL dans le fichier `queries.sql` qui se trouve à la racine du projet.

Pour pouvoir récupérer des recettes depuis l'API Spoonacular, il faut créer un compte sur [RapidAPI](https://rapidapi.com/), obtenir une clé API et la renseigner dans un fichier `.env` à la racine du projet :
```
API_KEY=to-modified
```

## Utilisation
Pour lancer l'app, il suffit de lancer le serveur PHP :
```bash
$ php -S localhost:8000 -t public
```

Pour développer, il est possible de lancer le build en mode watch :
```bash
$ npm run watch
```

