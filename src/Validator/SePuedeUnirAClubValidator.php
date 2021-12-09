<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use App\Service\ClubService;
use App\Entity\Empleado;


class SePuedeUnirAClubValidator extends ConstraintValidator
{
    private $clubService;

    public function __construct(ClubService $clubService) {
        $this->clubService = $clubService;
    }

    public function validate($protocol, Constraint $constraint)
    {
        if (!$constraint instanceof SePuedeUnirAClub) {
            throw new UnexpectedTypeException($constraint, SePuedeUnirAClub::class);
        }

        if($protocol->club) {
            if(!$protocol->id) {
                $this->context->buildViolation("Para asociar un empleado a un club debes especificar el id del empleado.")
                    ->atPath('club')
                    ->addViolation();
                return;
            } 
            if(!$this->clubService->haySitioEnClub($protocol)) {
                $this->context->buildViolation("El club está completo.")
                    ->atPath('club')
                    ->addViolation();
            }
            if(!$this->clubService->clubSePuedePermitirEmpleado($protocol)) {
                $this->context->buildViolation("El club no se puede permitir el salario de este empleado.")
                    ->atPath('club')
                    ->addViolation();
            }
            if(
                $protocol->club &&
                $protocol->tipoEmpleado == Empleado::TIPO_EMPLEADO_JUGADOR &&
                !$protocol->salario
            ) {
                $this->context->buildViolation("Los jugadores en un club deben tener un salario.")
                    ->atPath('club')
                    ->addViolation();
            }
            if(
                $protocol->club &&
                $protocol->tipoEmpleado == Empleado::TIPO_EMPLEADO_ENTRENADOR &&
                !$protocol->salario
            ) {
                $this->context->buildViolation("Los entrenadores en un club deben tener un salario.")
                    ->atPath('club')
                    ->addViolation();
            }
        }
    }
}