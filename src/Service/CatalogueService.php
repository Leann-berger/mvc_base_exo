<?php

namespace App\Service;

class CatalogueService
{
    private array $livres;

    public function __construct(array $livres)
    {
        $this->livres = $livres;
    }

    public function getLivres(string $genre = ''): array
    {
        $livres = [];
        foreach($this->livres as $livre){
            if($livre["genre"] == $genre){
                $livres[] = $livre;
            }
        }
        return $livres;
 
    }
}