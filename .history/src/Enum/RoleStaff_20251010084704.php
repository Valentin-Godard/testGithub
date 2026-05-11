<?php
namespace App\Enum;

enum RoleStaff: string {
    case ENTRAINEUR = 'Entraîneur';
    case MEDECIN = 'Médecin';
    case PREPARATEUR_PHYSIQUE = 'Préparateur Physique';
    
}