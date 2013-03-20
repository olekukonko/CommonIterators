<?php

namespace run;
use CachingIterator , Iterator ;
/**
 * Iterator that iterates over the first and last element of
 * an Iterator
 */
class FirstAndLastIterator extends CachingIterator
{
	/**
	 * 
	 * @param Iterator $iterator
	 */
    public function __construct(Iterator $iterator) {
        parent::__construct($iterator, self::TOSTRING_USE_KEY);
    }
 
    /**
     * Iterator::next — Return the next element
     *
     * @see Iterator::next()
     * @link http://php.net/manual/en/iterator.next.php
     */    
    public function next() {
        while (parent::hasNext()) {
            parent::next();
        }
    }
}

?>