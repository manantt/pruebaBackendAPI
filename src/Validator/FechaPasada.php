<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FechaPasada extends Constraint
{
    public $message = 'La fecha de nacimiento no es válida: la fecha debe de ser una fecha pasada.';

    public function validatedBy()
    {
        return static::class.'Validator';
    }
}