# FinderCine

Bienvenue sur le dépôt GitHub de FinderCine, un site de gestion de films développé en PHP.

## Prérequis

Avant de pouvoir utiliser le site, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **Serveur Apache :** Le site nécessite un serveur Apache pour fonctionner correctement. Si vous ne l'avez pas déjà installé, vous pouvez le faire en suivant les instructions disponibles sur le site officiel [Apache HTTP Server](https://httpd.apache.org/).

- **PHP :** Assurez-vous d'avoir PHP installé sur votre serveur. Vous pouvez obtenir la dernière version de PHP sur le site officiel de [PHP](https://www.php.net/).

## Configuration de la base de données

1. Copiez le fichier `credential.php.example` et renommez-le en `credential.php`.

2. Ouvrez le fichier `credential.php` dans votre éditeur de texte préféré.

3. Modifiez les paramètres de connexion à la base de données (`$dsn`, `$login`, `$mdp`) avec vos propres informations.

## Comment lancer le site

1. Assurez-vous d'avoir un serveur Apache fonctionnel et PHP installé sur votre machine.

2. Clonez ce dépôt sur votre machine en utilisant la commande suivante :
    ```
    git clone https://github.com/GraceKoffi/SAE-Scander-Samy-Grace-Younes-Azzedine.git
    ```

3. Placez le dossier cloné dans le répertoire de votre serveur web (par exemple, dans le répertoire `htdocs` pour Apache).

4. Ouvrez votre navigateur web et accédez au site en utilisant l'URL appropriée (par exemple, `http://localhost/sae/SAE-Scander-Samy-Grace-Younes-Azzedine/livrables/livrable10/src/?`).

5. Vous devriez maintenant voir le site de gestion de films. Assurez-vous d'avoir correctement configuré la base de données en suivant les étapes ci-dessus.

## Contribuer

Si vous souhaitez contribuer à ce projet, n'hésitez pas à créer une nouvelle branche, à effectuer vos modifications, puis à soumettre une demande de fusion.

Merci de contribuer au développement de FinderCine!
