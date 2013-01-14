<?php

namespace run;
use Iterator;

/**
 * 
 * @author Oleku
 *
 */
class RangeIterator implements Iterator {
	private $start;
	private $stop;
	private $increment;
	private $current;

	/**
	 * Construct the iterator
	 *
	 * @param int $start
	 *        	The starting number
	 * @param int $stop
	 *        	The ending number
	 * @param int $increment
	 *        	The increment (default 1)
	 */
	public function __construct($start, $stop, $increment = 1) {
		$this->start = $start;
		$this->stop = $stop;
		$this->increment = $increment;
		$this->rewind();
	}

	/**
	 * Iterator::current — Return the current element
	 * 
	 * @see Iterator::current()
	 * @link http://php.net/manual/en/iterator.current.php
	 */
	public function current() {
		return $this->current;
	}

	/**
	 * Iterator::key — Return the key element
	 * 
	 * @see Iterator::key()
	 * @link http://php.net/manual/en/iterator.key.php
	 */
	public function key() {
		return $this->current;
	}

	/**
	 * Iterator::next — Return the next element
	 * 
	 * @see Iterator::next()
	 * @link http://php.net/manual/en/iterator.next.php
	 */
	public function next() {
		$this->current += $this->increment;
	}

	/**
	 * Iterator::rewind — Rewind the Iterator to the first element
	 * 
	 * @see Iterator::rewind()
	 * @link http://php.net/manual/en/iterator.rewind.php
	 */
	public function rewind() {
		$this->current = $this->start;
	}

	/**
	 * Iterator::valid — Checks if current position is valid
	 * 
	 * @see Iterator::valid()
	 * @link http://php.net/manual/en/iterator.valid.php
	 */
	public function valid() {
		return $this->current <= $this->stop;
	}
}
?>