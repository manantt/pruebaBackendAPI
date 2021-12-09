<?php 

namespace App\Form\Model;

use App\Validator as Validaciones;
use App\Validator\FechaPasada;
use App\Entity\Empleado;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Validaciones\EdadMaximaCanterano
 * @Validaciones\SePuedeUnirAClub
 */
class EmpleadoDto 
{
    public $id;
    public $nombre;
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;
    public $telefono;
    public $salario;
    /**
     * @FechaPasada
     */
    public $fechaNacimiento;
    public $posicion;
    public $tipoEmpleado;
    public $club;

    public static function crearDesdeEmpleado(Empleado $empleado) : self
    {
        $dto = new self();
        $dto->nombre = $empleado->getNombre();
        $dto->email = $empleado->getEmail();
        $dto->telefono = $empleado->getTelefono();
        $dto->salario = $empleado->getSalario();
        $dto->fechaNacimiento = $empleado->getNombre();
        $dto->posicion = $empleado->getPosicion();
        $dto->tipoEmpleado = $empleado->getTipoEmpleado();
        $dto->club = $empleado->getClub() ? $empleado->getClub()->getId() : null;
        return $dto;
    }
}