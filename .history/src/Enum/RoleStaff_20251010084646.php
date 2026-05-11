<?php
namespace App\Enum;

enum RoleStaff: string {
    case ENTRAINEUR = 'Attaquant';
    case DEFENSEUR = 'Défenseur';
    case MILIEU = 'Milieu';
    case GARDIEN = 'Gardien';
}