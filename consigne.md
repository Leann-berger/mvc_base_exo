<<<<<<< HEAD
## 1. Afficher la page de commande
**Objectif** — Reprendre le parcours route → contrôleur → template.
1. Ajoutez un `case '/commande'` au `switch` de `public/index.php`. Appelez `commande()` sur `$homeController`.
2. Dans `HomeController`, créez cette méthode. Prenez `catalogue()` comme modèle pour appeler `render()` avec le nom `commande` et le titre « Devis de commande ».
3. Créez `template/template_commande.php`. Affichez le titre et une courte phrase qui explique à quoi sert le devis.
**Vérification** — Ouvrez `/commande`, puis `/catalogue` pour vérifier les deux parcours.


## 2. Construire le formulaire
**Objectif** — Envoyer deux valeurs au contrôleur avec POST.
1. Dans le template, ajoutez un formulaire avec `method="post"` et `action="/commande"`.
2. Ajoutez un champ texte `titre` et un champ numérique `quantite` avec un libellé pour chacun. Ajoutez un bouton **Calculer le devis**.
3. Dans `commande()`, donnez des valeurs initiales à `$data['titre']` et `$data['quantite']` pour afficher des champs vides au premier chargement.
**Vérification** — Envoyez le formulaire et repérez la requête `POST /commande` dans l’onglet Réseau du navigateur.
**Question** — Quelle valeur de l’attribut `name` retrouverez-vous comme clé dans `$_POST` ?


## 3. Afficher un récapitulatif de la saisie
**Objectif** — Lire les données HTTP dans le contrôleur et transmettre le résultat au template.
1. Dans `commande()`, utilisez `$_SERVER['REQUEST_METHOD']` pour distinguer l’ouverture de la page en GET de l’envoi en POST.
2. En POST, récupérez `titre` et `quantite`. Si une valeur manque ou arrive sous forme de tableau, traitez-la comme une chaîne vide. Placez les deux chaînes dans `$data`.
3. Dans le template, réaffichez les valeurs dans les champs et affichez un récapitulatif uniquement après un POST. Utilisez `htmlspecialchars()` pour afficher les saisies dans la page ou dans un attribut `value`.
**Vérification** — Envoyez « Le Hobbit » et `3`. Le titre et la quantité apparaissent dans le récapitulatif et restent visibles dans les champs. Ouvrez ensuite `/commande` directement pour retrouver le formulaire initial.


## 4. Valider la saisie et calculer le montant
**Objectif** — Séparer les états du formulaire et produire un résultat vérifiable.
1. Dans le contrôleur, retirez les espaces autour du titre et vérifiez qu’il reste au moins un caractère.
2. Vérifiez que la quantité représente un entier de 1 à 20. Faites cette vérification côté PHP même si vous ajoutez des contraintes HTML.
3. En cas d’erreur, passez les messages au template avec `$data['erreurs']`. Affichez-les près des champs et conservez la saisie.
4. Si les deux valeurs sont valides, multipliez la quantité par le prix unitaire de **1 250 centimes** (12,50 €). Passez le résultat au template et formatez-le en euros pour l’affichage.
```
| Saisie | Résultat attendu |
|---|---|
| Le Hobbit, 3 | 37,50 € |
| Titre composé d’espaces, 3 | Message sur le titre, aucun devis |
| Le Hobbit, 0 ou 21 | Message sur la quantité, aucun devis |
| Le Hobbit, 2,5 | Message sur la quantité, aucun devis |
```
**Vérification** — Si le navigateur bloque une saisie de test, retirez temporairement les contraintes du champ dans l’inspecteur pour vérifier la validation PHP.



## 5. Déplacer le calcul dans un service
**Objectif** — Appeler une méthode d’un objet et exploiter sa valeur de retour.
1. Créez `src/Service/CommandeService.php` dans le namespace `App\Service`.
2. Déplacez le prix unitaire et le calcul dans ce service. Créez une méthode `calculerTotal(int $quantite): int` qui reçoit une quantité déjà validée et retourne le montant en centimes.
3. Prenez `HomeService` comme modèle dans `HomeController`. Importez `CommandeService`, déclarez une propriété et instanciez le service dans le constructeur existant.
4. Dans `commande()`, après validation, appelez la méthode du service et transmettez le résultat au template.
**Vérification** — Rejouez les cas de l’exercice 4.
**Question** — De quelle information le service a-t-il besoin pour calculer le montant ?



## 6. Ajouter une remise à partir de cinq exemplaires
**Objectif** — Faire évoluer une règle dans le service et afficher son détail dans la vue.
1. Ajoutez la règle suivante dans `CommandeService`. À partir de **5 exemplaires**, appliquez une remise de **10 %** sur le sous-total.
2. Faites évoluer le contrat du service pour retourner un tableau associatif avec `sousTotal`, `remise` et `total`, en centimes. Adaptez le contrôleur et le template à ce retour.
3. Affichez le sous-total et le total. Affichez une ligne de remise quand son montant est supérieur à zéro.
```
| Quantité | Sous-total | Remise | Total   |
|----------|-----------:|-------:|--------:|
| 4        | 50,00 €    | 0,00 € | 50,00 € |
| 5        | 62,50 €    | 6,25 € | 56,25 € |
| 6        | 75,00 €    | 7,50 € | 67,50 € |
```
**Vérification** — Testez les trois quantités, puis envoyez une quantité invalide après un devis valide. La page doit afficher l’erreur sans reprendre le devis précédent.
=======
# TP progressif PHP POO et MVC — Mini-librairie
**Point de départ** — [mvc_base](https://github.com/mithridatem/mvc_base)
Les **exercices 1 à 4** constituent le tronc commun. Les **exercices 5 et 6** introduisent le **service**. 
Chaque exercice reprend le code produit à l’étape précédente.
## Démarrage
```bash
git clone https://github.com/mithridatem/mvc_base.git
cd mvc_base
composer install
php -S 127.0.0.1:8000 -t public
```
Ouvrez http://127.0.0.1:8000 dans votre navigateur.
**Le rendu** se fera dans un **repository github** : `fork` de la base `mvc_base`



## Exercice 1. Ajouter une page statique
**Objectif** — Relier une URL à une méthode du contrôleur et à un template.
1. Ajoutez un `case '/catalogue'` dans le `switch` de `public/index.php`.
2. Dans ce cas, appelez `catalogue()` sur l’objet `$homeController`.
3. Ajoutez la méthode `catalogue()` dans `HomeController`. Prenez `accueil()` comme modèle pour inclure `template/template_catalogue.php`.
4. Dans le template, affichez le titre **Catalogue** et le texte « Bienvenue dans la mini-librairie ».
**Vérification** — `/catalogue` affiche la nouvelle page et `/` affiche toujours l’accueil.
**Question** — Quel fichier décide de la méthode à appeler quand on ouvre `/catalogue` ?


## Exercice 2. Passer une donnée du contrôleur à la vue
**Objectif** — Suivre une valeur depuis le contrôleur jusqu’à son affichage.
1. Dans `catalogue()`, créez un tableau `$data` avec la clé `nomLibrairie` et la valeur `La Petite Librairie`.
2. Prenez `home()` comme modèle. Appelez `render()` avec `catalogue`, `Catalogue` et `$data` comme arguments.
3. Dans `template_catalogue.php`, affichez `$title` comme titre et `$data['nomLibrairie']` dans le contenu.
**Vérification** — Changez le nom dans le contrôleur et rechargez la page.
**Indice** — La méthode `render()` ajoute le préfixe `template_` et l’extension `.php`.


## Exercice 3. Afficher une liste de livres
**Objectif** — Parcourir un tableau de tableaux associatifs avec `foreach`.
1. Ajoutez la clé `livres` dans `$data`. Chaque livre est un tableau associatif avec les clés `titre`, `auteur` et `genre`.
2. Dans le template, parcourez `$data['livres']` et affichez une ligne par livre.

| Titre | Auteur | Genre |
|---|---|---|
| Le Petit Prince | Antoine de Saint-Exupéry | Conte |
| Le Hobbit | J. R. R. Tolkien | Fantasy |
| L’Île au trésor | Robert Louis Stevenson | Aventure |

**Vérification** — Ajoutez un quatrième livre dans le contrôleur. Il doit apparaître sans modifier le template.
**Bonus** — Si le tableau est vide, affichez « Aucun livre à afficher ». Ce message sera utilisé à l’exercice suivant.



## Exercice 4. Filtrer le catalogue avec un paramètre GET
**Objectif** — Distinguer le chemin utilisé par le routeur du paramètre lu par le contrôleur.
1. Ajoutez les liens **Tous les livres**, **Fantasy** et **Aventure** dans le template. Utilisez les trois premières URL du tableau ci-dessous.
2. Dans `catalogue()`, lisez le filtre avec `$_GET['genre'] ?? ''`.
3. Avec un `foreach` et un `if`, construisez la liste à afficher. Gardez tous les livres si le filtre est vide.
4. Transmettez la liste filtrée avec la clé `livres`. Réutilisez la boucle d’affichage de l’exercice 3 et son message de liste vide.

| URL | Résultat attendu avec les trois livres fournis |
|---|---|
| `/catalogue` | Les trois livres |
| `/catalogue?genre=Fantasy` | Le Hobbit |
| `/catalogue?genre=Aventure` | L’Île au trésor |
| `/catalogue?genre=Polar` | Aucun livre à afficher |

**Question** — Pourquoi le `case '/catalogue'` fonctionne-t-il encore avec `?genre=Fantasy` ?


## Exercice 5. Déplacer les données et le filtrage dans un service
**Objectif** — Instancier un service, appeler une méthode et utiliser sa valeur de retour.
1. Créez `src/Service/CatalogueService.php` dans le namespace `App\Service`.
2. Déplacez les livres dans une propriété du service. Déplacez la boucle de filtrage dans une méthode `getLivres(string $genre = ''): array` qui retourne les livres correspondants.
3. Dans `HomeController`, prenez `HomeService` comme modèle. Importez `CatalogueService`, déclarez une propriété et instanciez le service dans le constructeur existant.
4. Dans `catalogue()`, lisez toujours le paramètre GET. Passez le genre à `getLivres()` et placez le résultat dans `$data['livres']`.
**Vérification** — Rejouez les quatre URL de l’exercice 4. Elles doivent donner les mêmes résultats.
**Question** — Quelle méthode peut-on appeler pour réutiliser le filtrage et quelle donnée faut-il lui transmettre ?


## Exercice 6. Ajouter une page de détail
**Objectif** — Réutiliser le même service dans une deuxième action du contrôleur.
1. Ajoutez un `id` entier positif et unique à chaque livre.
2. Ajoutez `findLivreById(int $id): ?array` dans `CatalogueService`. La méthode retourne le livre trouvé ou `null`.
3. Ajoutez la route `/livre` et la méthode `livre()` dans `HomeController`. Lisez le paramètre GET `id`, vérifiez qu’il représente un entier positif, puis appelez le service si l’identifiant est valide.
4. Créez `template/template_livre.php`. Affichez le titre, l’auteur et le genre si le livre existe. Sinon, affichez « Livre introuvable ».
5. Dans le catalogue, ajoutez un lien **Voir le détail** pour chaque livre, par exemple `/livre?id=1`.
**Vérification** — Cliquez sur chaque lien, puis testez `/livre`, `/livre?id=abc` et `/livre?id=999`. Ces trois URL doivent afficher « Livre introuvable ».
>>>>>>> debf80b1a6b7e895e8d95a826694e5d018beccb7
