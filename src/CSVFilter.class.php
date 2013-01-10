<?php

namespace Run;

use FilterIterator ;

/**
 *
 * @author Oleku
 * @link http://stackoverflow.com/a/13558050/1226894
 */
class CSVFilter extends FilterIterator {
    protected $filter = array();
    protected $errors = array();

    public function __construct(CSVIterator $iterator) {
        parent::__construct($iterator);
    }

    public function addFilter($index, Callable $callable) {
        $this->filter[$index] = $callable;
        $this->errors[$callable] = 0;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function accept() {
        $line = $this->getInnerIterator()->current();
        $x = true;
        foreach ($this->filter  as $key => $var ) {
            if (isset($line[$key])) {
                $func = $this->filter[$key];
                $func($var) or $this->errors[$func]++ and $x = false;
            }
        }
        return $x;
    }
}
?>