<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EdadMaximaCanterano extends Constraint
{
    public $message = 'La fecha de nacimiento no es válida: un canterano no debe tener más de 23 años.';

    public function validatedBy()
    {
        return static::class.'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}