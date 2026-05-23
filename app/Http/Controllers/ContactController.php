<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function index()
    {
        $faqs = [
            [
                'question' => 'Intervenez-vous en dehors de Yaoundé ?',
                'answer'   => 'Absolument. Bien que notre siège soit situé à Yaoundé, les équipes de POLAM SARL sont mobiles
                            et interviennent sur toute l\'étendue du territoire national (Cameroun) ainsi que dans la
                            sous-région, selon l\'envergure de votre projet.',
            ],
            [
                'question' => 'Comment se déroule la demande de devis ?',
                'answer'   => 'Une fois que vous nous contactez (via le formulaire, WhatsApp ou par téléphone), un expert
                            analyse votre demande. Si nécessaire, nous programmons une visite technique sur le site pour
                            évaluer les contraintes réelles. Ensuite, nous vous transmettons un devis détaillé, transparent
                            et gratuit sous 24 à 48 heures.',
            ],
            [
                'question' => 'Proposez-vous des garanties sur le matériel installé ?',
                'answer'   => 'Oui. Tous les équipements que nous fournissons (panneaux solaires, caméras, câblage,
                            équipements IT) proviennent de marques reconnues et bénéficient de la garantie constructeur.
                            De plus, nous offrons une garantie sur notre main-d\'œuvre et un service après-vente (SAV)
                            réactif en cas d\'anomalie.',
            ],
            [
                'question' => 'Prenez-vous en charge la maintenance de systèmes que vous n\'avez pas installés ?',
                'answer'   => 'Oui, nous proposons des services de maintenance préventive et curative (dépannage) pour les
                            installations électriques, parcs informatiques, systèmes de sécurité et équipements biomédicaux
                            existants. Nous réalisons d\'abord un audit technique de l\'existant avant toute intervention.',
            ],
        ];

        return view('home.pages.contact', compact('faqs'));
    }

    public function index_admin()
    {
        if (auth()->user()->cannot('viewAny', \App\Models\Contact::class)) {
            return redirect()->route('admin_dashboard')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour accéder à la gestion des contacts.");
        }
        return view('dashboard.contacts.index');
    }
}
