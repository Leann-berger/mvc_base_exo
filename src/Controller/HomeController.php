<?php

namespace App\Controller;

//Import du service
use App\Service\HomeService;

class HomeController
{

    private HomeService $homeService;

    public function __construct()
    {
        //$this->homeService = $homeService;
        $this->homeService = new HomeService();
    }

    //Méthode qui retourne le template_home.php avec la méthode render
    public function home(): mixed
    {
        //Récupération du nom en GET
        $nom = $this->homeService->getNomUrl();
        //stockage dans le tableu $data
        $data["nom"] = $nom;
        //retourne le template_home.php avec les données
        return $this->render("home", "Accueil", $data);
    }

    //Méthode pour retourner la page Accueil manuel
    public function accueil(): void 
    {
        //Variable pour passer le titre au template
        $title = "Accueil";
        include __DIR__ . "/../../template/template_accueil.php";
    }

    public function catalogue() : mixed 
    {
        //Titre de la librairie
        $data["nomLibrairie"] = "La Petite Librairie";
        //Tableau de livres
        $data["livres"] = [
            ["titre"=>"Le Petit Prince", "auteur" =>"Antoine de Saint-Exupéry", "genre"=>"Conte"],
            ["titre"=>"Le Petit Chaperon rouge", "auteur" =>"Antoine de Saint-Exupéry", "genre"=>"Conte"],
            ["titre"=>"Le Hobbit ", "auteur" =>"J. R. R. Tolkien", "genre"=>"Fantasy"],
            ["titre"=>"Le Seigneur des anneaux ", "auteur" =>"J. R. R. Tolkien", "genre"=>"Fantasy"],
            ["titre"=>"L’Île au trésor", "auteur" =>"Robert Louis Stevenson", "genre"=>"Aventure"],
            ["titre"=>"Le conte de Montécristo", "auteur" =>"Robert Louis Stevenson", "genre"=>"Aventure"]
        ];

        //tester si la super globale $_GET["genre"] existe
        if (isset($_GET["genre"])) {
            //tableau de livres filtrés
            $livresFiltre = [];
            //reconstruire le tableau de livre
            foreach ($data["livres"] as $livre) {
                //Tester si un livre posséde le genre (depuis $_GET["genre])
                if ($_GET["genre"] == $livre["genre"]) {
                    //Ajouter le livre au tableau de livres filtrés
                    $livresFiltre[] = $livre;
                }
            }
            //modifier le tableau $data["livre"]
            $data["livres"] = $livresFiltre;
        }
        //retour du template
        return $this->render("catalogue", "Catalogue", $data);
    }

    //Méthode qui va retourner les templates
    private function render(string $template, ?string $title, array $data = []): mixed
    {
        return include __DIR__ . "/../../template/template_" . $template . ".php";
    }
    
    public function commande() : mixed
    {
        return $this->render("commande", "Devis de commande", $data ?? []);
    }
}



