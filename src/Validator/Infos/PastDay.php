<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PastDay extends Constraint
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
