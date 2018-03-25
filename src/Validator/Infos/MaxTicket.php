<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MaxTicket extends Constraint
{

    /**
     * @var string
     */
    public $message;

    /**
     * @const int
     */
    const MAXTICKET = 1000;

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
