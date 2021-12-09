<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Entity\Empleado;

class EdadMaximaCanteranoValidator extends ConstraintValidator
{
    const EDAD_MAXIMA_CANTERANO = 23;
    public function validate($protocol, Constraint $constraint)
    {
        if (!$constraint instanceof EdadMaximaCanterano) {
            throw new UnexpectedTypeException($constraint, EdadMaximaCanterano::class);
        }

        if ($protocol->tipoEmpleado == Empleado::TIPO_EMPLEADO_CANTERANO) {
            $ahora = new \Datetime();
            $fechaNacimiento = new \Datetime($protocol->fechaNacimiento);
            $edad = date_diff($ahora, $fechaNacimiento);
            if($edad->y >= self::EDAD_MAXIMA_CANTERANO) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('fechaNacimiento')
                    ->addViolation();
            }
        }
    }
}