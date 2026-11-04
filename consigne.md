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