<?php
include "../vendor/autoload.php";

//Analyse de l'URL avec parse_url() et retourne ses composants
$url = parse_url($_SERVER['REQUEST_URI']);
//test soit l'url a une route sinon on renvoi à la racine
$path = isset($url['path']) ? $url['path'] : '/';

//importer les classes
use App\Controller\HomeController;

//instancier un objet HomeController
$homeController = new HomeController([
        ["titre"=>"Le petit Prince","auteur"=>"Antoine de st-Exuperie", "genre" =>"conte"],
       
        ["titre"=>"Le Hobbit","auteur"=>"J.R.R Tolkien", "genre" =>"Fantasy"],
        
        ["titre"=>"l'îles au trésor","auteur"=>"Robert Louis Stevenson", "genre" =>"Aventure"]
        ]);

switch ($path) {
    //route racine
    case '/':
        //page sans la méthode render
        $homeController->accueil();  
        break;
    //paramètre dans l'url : http://127.0.0.1:8000/home
    case '/home':
        //appel à la méthode du Controller
        $homeController->home();   
        break;
    case '/catalogue':
        $homeController->catalogue();
        break;
    // //autre route non définie -> erreur 404
    default:
        echo "erreur 404";
        break;
}