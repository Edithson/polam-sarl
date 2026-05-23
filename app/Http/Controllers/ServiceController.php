<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = [
            [
                'id'          => 'electrique',
                'badge'       => 'Service Principal',
                'title'       => 'Installation Électrique Domestique & Tertiaire',
                'description' => 'POLAM SARL assure l\'étude, la conception et la mise en œuvre de tous vos projets
                                  d\'installation électrique — du logement individuel aux bâtiments tertiaires et industriels,
                                  dans le strict respect des normes en vigueur.',
                'image'       => 'media/img/services/installation_electrique_domestique.webp',
                'image_alt'   => 'Installation Électrique',
                'image_label' => 'Installation Électrique',
                'points'      => [
                    'Étude et conception de plans électriques aux normes',
                    'Câblage, pose de tableaux électriques et appareillage',
                    'Mise en conformité des installations existantes',
                    'Installation domotique et gestion intelligente de l\'énergie',
                ],
            ],
            [
                'id'          => 'solaire',
                'badge'       => 'Énergie Renouvelable',
                'title'       => 'Énergie Solaire & Systèmes Photovoltaïques',
                'description' => 'Réduisez votre facture énergétique et gagnez en autonomie grâce à nos solutions solaires
                                  sur mesure — dimensionnées, installées et maintenues par nos techniciens certifiés.',
                'image'       => 'media/img/services/installation_solaire.png',
                'image_alt'   => 'Énergie Solaire',
                'image_label' => 'Énergie Solaire',
                'points'      => [
                    'Étude de faisabilité et dimensionnement des installations solaires',
                    'Pose de panneaux photovoltaïques et onduleurs',
                    'Installation de systèmes de stockage et de batteries',
                    'Systèmes hybrides solaire + réseau pour continuité électrique',
                ],
            ],
            [
                'id'          => 'securite',
                'badge'       => 'Sécurité',
                'title'       => 'Vidéosurveillance, Alarme & Contrôle d\'Accès',
                'description' => 'Protégez vos biens, vos locaux et vos collaborateurs grâce à nos systèmes de sécurité
                                  intégrés — vidéosurveillance HD, alarmes techniques et contrôle d\'accès biométrique.',
                'image'       => 'media/img/services/securite2.png',
                'image_alt'   => 'Vidéosurveillance & Alarme',
                'image_label' => 'Sécurité & Accès',
                'points'      => [
                    'Installation de caméras IP et systèmes CCTV HD / 4K',
                    'Systèmes d\'alarme intrusion et détection incendie',
                    'Contrôle d\'accès par badge, biométrie ou code',
                ],
            ],
            [
                'id'          => 'reseaux',
                'badge'       => 'Télécommunications',
                'title'       => 'Réseaux & Télécommunications',
                'description' => 'Connectez votre organisation avec des infrastructures réseau robustes et évolutives.
                                  De la fibre optique au Wi-Fi professionnel, nous concevons des solutions sur mesure.',
                'image'       => 'media/img/services/reseau_telecom.jpg',
                'image_alt'   => 'Réseaux & Télécoms',
                'image_label' => 'Réseaux & Télécoms',
                'points'      => [
                    'Câblage structuré RJ45, fibre optique et baie de brassage',
                    'Déploiement de réseaux Wi-Fi professionnel (indoor/outdoor)',
                    'Configuration de routeurs, switches et VPN sécurisés',
                ],
            ],
        ];

        return view('home.pages.service', compact('services'));
    }
}
