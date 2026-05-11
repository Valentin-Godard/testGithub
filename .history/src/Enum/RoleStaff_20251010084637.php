<?php
namespace App\Enum;

enum RoleS: string {
    case ATTAQUANT = 'Attaquant';
    case DEFENSEUR = 'Défenseur';
    case MILIEU = 'Milieu';
    case GARDIEN = 'Gardien';
}