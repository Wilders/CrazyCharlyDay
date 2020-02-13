# CrazyCharlyDay

CrazyCharlyDay 2020 - Equipe Crazy Charly Frogs

## Installation

Utilisez [composer](https://getcomposer.org/) pour installer le projet.

```bash
git clone git@github.com:Wilders/CrazyCharlyDay.git
cd CrazyCharlyDay
composer install
```
Créez un fichier .env à la racine: exemple
```bash
DB_DRIVER="mysql"
DB_HOST="localhost"
DB_NAME="frogs"
DB_USER="root"
DB_PWD="6su@root"
DB_CHARSET="utf8"
DB_COLLATION="utf8_unicode_ci"
DB_PREFIX=""
```
Il faut ensuite renommer le fichier de configuration (situé à la racine) nommé **.env.example** en **.env**
Puis le remplir avec ses propres informations.

## Utilisation

Lancez un serveur XAMP, importez le fichier de création de la BDD ([sql/frogs.sql](https://github.com/Wilders/CrazyCharlyDay/blob/master/sql/frogs.sql)) et connectez-vous sur le site.

OU

Vous pouvez directement accéder à la [dernière release](https://github.com/Wilders/CrazyCharlyDay/releases/latest), [disponible ici](https://flachag.com)

## Jeu de données pour tester
...

## Technologies utilisées

- [x] *Nous utilisons [Slim](https://github.com/slimphp/Slim) 3.12*
- [x] *Nous utilisons [Eloquent](https://github.com/illuminate/database) 6.14*
- [x] *Nous utilisons [SlimTwigView](https://github.com/slimphp/Twig-View) 2.5*
- [x] *Nous utilisons [Flash](https://github.com/slimphp/Slim-Flash) 0.4*
- [x] *Nous utilisons [SlimCsrf](https://github.com/slimphp/Slim-Csrf) 0.8*

## Fonctionnalités

### Gestion des comptes utilisateurs

- [x] ~~*1. Accès sans authentification*~~
- [x] ~~*2. Création d'un nouveau compte*~~
- [x] ~~*3. Accès avec authentification*~~
- [x] ~~*4. Modification de compte*~~
- [x] ~~*5. Affichage de la liste des utilisateurs*~~
- [x] ~~*6. Compte administrateur*~~

### Gestion des créneaux
- [x] ~~*7. Création d'un créneau*~~
- [x] ~~*8. Activation/Désactivation d'un créneau*~~
- [x] ~~*9. Affichage de la liste des créneaux*~~
- [x] ~~*9bis. Modification/Suppression des créneaux*~~

### Gestion des besoins
- [x] ~~*10. Création d’un besoin (pour les administrateurs)*~~
- [x] ~~*11. Listes des besoins*~~
- [x] ~~*12. Modification et suppression d'un besoin*~~
- [x] ~~*13. Les prévisions de permanence d’un membre*~~

### Les prévisions de permanence pour la coopérative
- [x] ~~*18. Affichage des permanences d'un créneau*~~
- [x] ~~*19. Affichage de toutes les permanences*~~

### Jeu de données
admin:adminadmin
user:useruser


## Contributions
**SAYER Jules** - SI2 @[Wilders](https://github.com/Wilders/CrazyCharlyDay/commits?author=Wilders)

**PERNOT Anthony** - AI2 @[anthopernot](https://github.com/Wilders/CrazyCharlyDay/commits?author=anthopernot)

**CHEVALIER Nathan** - AI2 @[FuretVolant](https://github.com/Wilders/CrazyCharlyDay/commits?author=FuretVolant)

**MATHIEU Jean** - AI2 @[kyouis](https://github.com/Wilders/CrazyCharlyDay/commits?author=kyouis)

**CHAGRAS Flavien** - SI2 @[Flachag](https://github.com/Wilders/CrazyCharlyDay/commits?author=Flachag)
