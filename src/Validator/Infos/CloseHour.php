<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CloseHour extends Constraint
{
    /**
     * @var string
     */
    public $message;

    /**
     * @Const int
     */
    const CLOSEHOUR = 21;

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
