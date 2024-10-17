Repos pour le labo Laravel de L'ISL.
Pour récupérer les dépendances au tout début, faire un ```composer install``` pour obtenir toutes les dépendances (stocké dans le dossier vendor)

// GIT

- Pour récupérer un dossier (repo pour Repository) : ``` git clone ``` (https://gihub.com/(repo))
- (n'oubliez de faire un ```composer install```) pour les dépendances

// En cas de changement (Ajout/ modifications)
- Pour récupérer du contenu : ``` git pull ``` (c'est une combinaison de 2 commandes : git fetch ET un git merge)

// Si je veux créer une branche
commande : git checkout -b (pour branche) (NomDeLaBrancheACreer)

Exemples : 

// Creer une branche
- git checkout -b laboTestNicolas (en local) / git push -u origin laboTestNicolas (sur GitHub)
- git status => lister les fichiers modifiés / ajouté / supprimés
- git add . (le point c'est pour tout les fichiers, sinon spécifier le chemin de votre / vos fichiers) => Fichier(s) en stage de STAGING ! 
- git commit (renvoi vers un shell interactif) / git commit -m "Mon message" (plus souvent utilisé)
=> Associer les fichiers en staging avec le message 
- git push (enregistrer les modifications - De base c'est en local)
- git push --upstream (-u) origin (nomDeLaBranche) => Pousser sur Github

// Pour revenir a une autre branche
git checkout (nomDeLaBranche)

// Pour supprimer une branche locale
git branch -d (nomDeLaBranche)

// Pour supprimer une branche distante 
git push origin --delete nomDeLaBranche

// Lister les branches locales
git branch

// Lister les branches distante
git ls-remote
