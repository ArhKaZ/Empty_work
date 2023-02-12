# Initialisation du projet

1) Cloner ou télécharger le projet
2) Lancer la commande `composer update`
3) Configurer les accès à MySQL dans le fichier `.env`
4) Lancer la commande `php bin/console doctrine:database:create`
5) Lancer la commande `php bin/console make:migration`
6) Lancer la commande `php bin/console doctrine:migrations:migrate`
7) Lancer la commande `php bin/console doctrine:fixtures:load --append`
8) Lancer la commande `symfony serve -d`
