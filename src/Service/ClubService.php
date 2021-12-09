<?php

namespace App\Service;

use League\Flysystem\FilesystemOperator;
use App\Entity\Empleado;
use App\Repository\ClubRepository;
use App\Repository\EmpleadoRepository;

class ClubService
{
    private $clubRepository;
    private $empleadoRepository;

    public function __construct(ClubRepository $clubRepository, EmpleadoRepository $empleadoRepository) {
        $this->clubRepository = $clubRepository;
        $this->empleadoRepository = $empleadoRepository;
    }

    public function puedeEntrarEnClub($empleado, $club, $salario) : bool {
        return $this->haySitioEnClub($empleado, $club) && $this->clubSePuedePermitirEmpleado($empleado, $club, $salario);
    }

    /**
     * Comprueba si hay hueco en el club para un empleado
     */
    public function haySitioEnClub($empleadoDto) : bool
    {
        
        $club = $this->clubRepository->find($empleadoDto->club);
        $empleado = $this->empleadoRepository->find($empleadoDto->id);
        // no existe el club
        if(!$club) { 
            return false;
        }
        // no hay cambio de club
        if($empleado->getClub() && $empleado->getClub()->getid() == $club->getId()) { 
           return true;
        } 
        // es jugador y el club ha llegado al máximo de jugadores
        if(
            $empleadoDto->tipoEmpleado == Empleado::TIPO_EMPLEADO_JUGADOR &&
            !$club->aceptaJugadores()
        ) {
            return false;
        }
        // es entrenador y el club no tiene entrenador
        if(
            $empleadoDto->tipoEmpleado == Empleado::TIPO_EMPLEADO_ENTRENADOR &&
            ($club->getEntrenador() && $club->getEntrenador()->getId() != $empleadoDto->id)
        ) {
            return false;
        }
        return true;
    }

    /**
     * Comprueba si un club puede permitirse pagar el salario de un empleado
     */
    public function clubSePuedePermitirEmpleado($empleadoDto) : bool
    {
        $club = $this->clubRepository->find($empleadoDto->club);
        $salarioActual = 0;
        // comprueba si ya es un empleado del club (modificación salarial)
        foreach ($club->getEmpleados() as $key => $empleadoClub) {
            if($empleadoDto->id == $empleadoClub->getId()) {
                $salarioActual = $empleadoClub->getSalario();
                break;
            }
        }
        return $club->getSalarioTotal() - $salarioActual + $empleadoDto->salario <= $club->getlimiteSalarial();
    }
}