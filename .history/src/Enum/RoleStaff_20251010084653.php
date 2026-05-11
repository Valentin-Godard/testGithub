<?php
namespace App\Enum;

enum RoleStaff: string {
    case ENTRAINEUR = 'Entraîneur';
    case DEFENSEUR = 'Défenseur';
    case MILIEU = 'Milieu';
    case GARDIEN = 'Gardien';
}