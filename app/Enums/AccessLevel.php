<?php

namespace App\Enums;

enum AccessLevel: string {
    case NONE = 'none';
    case VIEW = 'view';     // Lecture seule
    case AUTHOR = 'author'; // Création + gestion de ses propres contenus
    case FULL = 'full';     // Total (Édition/Suppression de tout)
}
