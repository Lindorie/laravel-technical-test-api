<?php

namespace App\Enums;

enum ProfilStatutEnum: string
{
    case EN_ATTENTE = 'en_attente';
    case ACTIF = 'actif';
    case INACTIF = 'inactif';
}
