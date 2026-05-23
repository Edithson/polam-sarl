<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $timeline = [
            [
                'year'        => '2019',
                'title'       => 'Création de POLAM SARL',
                'description' => 'Lancement des activités à Yaoundé avec une vision claire : rendre la technologie
                                  accessible à tous. Premiers contrats en installation électrique résidentielle.',
            ],
            [
                'year'        => '2020',
                'title'       => 'Élargissement du portefeuille',
                'description' => 'Extension aux installations d\'énergie solaire et aux systèmes de vidéosurveillance.
                                  Premiers contrats tertiaires avec des PME locales.',
            ],
            [
                'year'        => '2022',
                'title'       => 'Pôle Biomédical & Informatique',
                'description' => 'Lancement du service de maintenance des équipements biomédicaux et informatiques.
                                  Consolidation de la présence sur Yaoundé et Douala.',
            ],
            [
                'year'        => '2025',
                'title'       => 'Innovation & Expansion',
                'description' => 'Intégration de solutions de monitoring intelligent et d\'automatisation avancée.
                                  Vision d\'expansion vers les marchés d\'Afrique centrale.',
            ],
            [
                'year'        => '2026',
                'title'       => 'Lancement de notre vitrine web',
                'description' => 'Développement d\'une plateforme en ligne pour présenter nos services, faciliter les demandes de devis
                                  et renforcer notre engagement envers la transparence et la satisfaction client.',
            ],
        ];

        return view('home.pages.about', compact('timeline'));
    }
}
