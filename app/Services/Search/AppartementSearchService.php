<?php

namespace App\Services\Search;

use App\Models\Appartement;

class AppartementSearchService
{
    // public function buildQuery(Appartement $appartement): string
    // {
    //     $property = $appartement->property;
    //     $ville = $property?->ville;
    //     $pays = $property?->pays;
    //     $property_type = $property?->type; 
    //     $property_category = $property?->category;

    //     $tarifs = $appartement->tarifications
    //         ->map(function ($t) {
    //             return "{$t->nbr_of_sejour} {$t->sejour} à {$t->price}";
    //         })
    //         ->implode(' ');

    //     return collect([
    //         // Appartement
    //         $appartement->title,
    //         cleanHtmlForSearch($appartement->description),
    //         $appartement->type?->libelle,
    //         $appartement->type?->description,
    //         $appartement->commodities,
    //         $appartement->nbr_room ? $appartement->nbr_room . ' chambre' . ($appartement->nbr_room > 1 ? 's' : '') : null,
    //         $appartement->nbr_bathroom ? $appartement->nbr_bathroom . ' salle de bain' : null,

    //         // Propriété
    //         $property?->title,
    //         cleanHtmlForSearch($property?->description),
    //         $property_type?->libelle,
    //         $property_type?->description,
    //         $property_category?->libelle,
    //         $property_category?->description,
    //         $property?->address,

    //         // Localisation
    //         $ville?->code,
    //         $ville?->label,
    //         $pays?->code,
    //         $pays?->label,

    //         // Tarification
    //         $tarifs,
    //     ])
    //         ->filter()
    //         ->implode(' ');
    // }
    
    public function buildQuery(Appartement $appartement): string
    {
        $property = $appartement->property;
        $ville = $property?->ville;
        $pays = $property?->pays;
        $property_type = $property?->type;
        $property_category = $property?->category;

        $tarifs = $appartement->tarifications
            ->map(fn($t) => "{$t->nbr_of_sejour} {$t->sejour} à {$t->price}")
            ->implode(' ');

        return collect([
            // Appartement
            $appartement->title,
            cleanHtmlForSearch($appartement->description),
            $appartement->type?->libelle,
            $appartement->type?->description,
            $appartement->commodities,
            $appartement->nbr_room ? $appartement->nbr_room . ' chambre' . ($appartement->nbr_room > 1 ? 's' : '') : null,
            $appartement->nbr_bathroom ? $appartement->nbr_bathroom . ' salle de bain' : null,

            // Propriété
            $property?->title,
            cleanHtmlForSearch($property?->description),
            $property_type?->libelle,
            $property_type?->description,
            $property_category?->libelle,
            $property_category?->description,
            $property?->address,

            // Localisation
            $ville?->code,
            $ville?->label,
            $pays?->code,
            $pays?->label,

            // Tarification
            $tarifs,
        ])->filter()->implode(' ');
    }
}
