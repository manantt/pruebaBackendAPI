<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class FechaPasadaValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FechaPasada) {
            throw new UnexpectedTypeException($constraint, FechaPasada::class);
        }

        $ahora = new \Datetime();
        $fechaNacimiento = new \Datetime($value);
        if($fechaNacimiento > $ahora) {
            $this->context->buildViolation($constraint->message)
                ->atPath('fechaNacimiento')
                ->addViolation();
        }
    }
}