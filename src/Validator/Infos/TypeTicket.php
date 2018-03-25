<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TypeTicket extends Constraint
{
    /**
     * @var string
     */
    public $message;

    /**
     * @const int
     */
    const LIMITHOUR = 14;

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
