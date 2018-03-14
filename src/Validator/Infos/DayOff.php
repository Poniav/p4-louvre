<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DayOff extends Constraint
{

    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $dayoff = ['01/01', '02/04', '01/05', '08/05', '10/05', '21/05', '14/07', '15/08', '01/11', '11/11', '25/12'];

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
