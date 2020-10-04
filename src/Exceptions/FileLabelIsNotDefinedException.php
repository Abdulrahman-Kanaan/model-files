<?php

namespace AKanaan\ModelFiles\Exceptions;

use Exception;

class FileLabelIsNotDefinedException extends Exception
{
    protected $class;
    protected $property;

    public function __construct($label) {
        parent::__construct("Label '{$label}' is not defined in 'attaches' array on this object.");
    }
}
