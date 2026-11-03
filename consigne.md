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