<?php
namespace RedwaneValentin\Foot2Club\Enum;

enum Role: string {
    case ATTAQUANT = 'Attaquant';
    case DEFENSEUR = 'Défenseur';
    case MILIEU = 'Milieu';
    case GARDIEN = 'Gardien';
}