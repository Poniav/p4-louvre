<?php

namespace App\Validator\Tickets;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NextDay extends Constraint
{

    /**
     * @var string
     */
    public $message;

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
