<?php

namespace Run;

use IteratorIterator;

/**
 *
 * @author Oleku
 *        
 */
class NoRewindLimitIterator extends IteratorIterator {
	private $start, $count, $next;

	/**
	 *
	 * @param Iterator $it        	
	 * @param int $start        	
	 * @param int $count        	
	 */
	public function __construct(Iterator $it, $start, $count) {
		parent::__construct($it);
		$this->start = max(0, $start);
		$this->count = max(0, $count);
	}

	/**
	 * Iterator::rewind — Rewind the Iterator to the first element
	 *
	 * @see Iterator::rewind()
	 * @link http://php.net/manual/en/iterator.rewind.php
	 */
	public function rewind() {
		$start = $this->start;
		while ( $start -- ) {
			parent::next();
		}
		$this->next = 0;
	}

	/**
	 * Iterator::next — Return the next element
	 *
	 * @see Iterator::next()
	 * @link http://php.net/manual/en/iterator.next.php
	 */
	public function next() {
		parent::next();
		$this->next ++;
	}

	/**
	 * Iterator::valid — Checks if current position is valid
	 *
	 * @see Iterator::valid()
	 * @link http://php.net/manual/en/iterator.valid.php
	 */
	public function valid() {
		if (! parent::valid())
			return false;
		return $this->next < $this->count;
	}
}

?>