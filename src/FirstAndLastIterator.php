<?php

namespace Run;
use CachingIterator ;
/**
 * Iterator that iterates over the first and last element of
 * an Iterator
 */
class FirstAndLastIterator extends CachingIterator
{
    public function __construct(Iterator $iterator) {
 
        parent::__construct($iterator, self::TOSTRING_USE_KEY);
    }
 
    public function next() {
 
        while (parent::hasNext()) {
            parent::next();
        }
    }
}

?>