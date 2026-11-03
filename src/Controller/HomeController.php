<?php

namespace App\Controller;

//Import du service
use App\Service\HomeService;
use App\Service\CatalogueService;

class HomeController
{

    private HomeService $homeService;
    private CatalogueService $catalogueService;

    public function __construct(
        array $livres
    )
    {
        //$this->homeService = $homeService;
        $this->homeService = new HomeService();
        $this->catalogueService = new CatalogueService($livres);
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

    //Méthode qui va retourner les templates
    private function render(string $template, ?string $title, array $data = []): mixed
    {
        return include __DIR__ . "/../../template/template_" . $template . ".php";
    }


    public function catalogue(): void
    {
        $data = ["nomLibrairie"=> "La Petite Librairie"];

        // if($_GET){
        //     $livres = [];
        //     foreach($data["livres"] as $livre){
        //         if($livre["genre"] == $_GET["genre"]){
        //             $livres[] = $livre;
        //         }
        //     }
        //     $data["livres"] = $livres;
        // }

        $genre = $_GET['genre'];
        $data['livres'] = $this->catalogueService->getLivres($genre);

        

        $this->render("catalogue", "Catalogue", $data);
    }
}
