<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'logo', 'name', 'slogan', 'phones', 'socials',
        'email', 'adresse', 'bp', 'horaire'
    ];

    // Conversion automatique du JSON en Array PHP
    protected $casts = [
        'phones' => 'array',
        'socials' => 'array',
    ];

    /**
     * Récupère l'unique instance de réglages ou retourne des valeurs par défaut.
     */
    public static function getSettings()
    {
        $settings = self::first();

        if (!$settings) {
            // Création d'un objet temporaire avec tes données par défaut
            return (object) [
                'name' => 'CINV-CORSA',
                'logo' => 'default-logo.png',
                'phones' => [],
                'socials' => [],
                'email' => 'contact@cinvcorsa.com',
                // Ajoute tes autres valeurs par défaut ici
            ];
        }

        return $settings;
    }

    /**
     * Liste des réseaux sociaux autorisés (Enumération simulée)
     */
    public static function availableSocials(): array
    {
        return [
            'facebook'  => 'Facebook',
            'twitter'   => 'X (Twitter)',
            'instagram' => 'Instagram',
            'linkedin'  => 'LinkedIn',
            'youtube'   => 'YouTube',
            'whatsapp'  => 'WhatsApp'
        ];
    }

    public static function getCachedSettings()
    {
        return Cache::rememberForever('site_settings', function () {
            return self::first() ?? new self([
                'name' => 'CINV-CORSA',
                'logo' => 'default-logo.png'
            ]);
        });
    }

    public static function clearCache()
    {
        Cache::forget('site_settings');
    }
}
