<?php 

namespace App\Form\Model;

use App\Entity\Club;

class ClubDto 
{
    public $nombre;
    public $base64escudo;
    public $limiteSalarial;

    public static function crearDesdeClub(Club $club) : self
    {
        $dto = new self();
        $dto->nombre = $club->getNombre();
        $dto->escudo = "";
        $dto->limiteSalarial = $club->getLimiteSalarial();
        return $dto;
    }
}