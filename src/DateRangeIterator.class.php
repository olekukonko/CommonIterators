<?php

namespace run\filter;

use DateTime, Iterator;

class DateRangeIterator implements Iterator {
	private $original;
	private $start;
	private $end;
	private $modify;

	public function __construct(DateTime $start, DateTime $end, $modify) {
		$this->original = $start;
		$this->start = $start;
		$this->end = $end;
		$this->modify = $modify;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->start = $this->original;
	}

	/**
	 * Iterator::valid — Checks if current position is valid
	 *
	 * @see Iterator::valid()
	 * @link http://php.net/manual/en/iterator.valid.php
	 */
	public function valid() {
		return $this->start < $this->end;
	}

	/**
	 * Iterator::current — Return the current element
	 *
	 * @see Iterator::current()
	 * @link http://php.net/manual/en/iterator.current.php
	 */
	public function current() {
		return $this->start;
	}

	/**
	 * Iterator::key — Return the key element
	 *
	 * @see Iterator::key()
	 * @link http://php.net/manual/en/iterator.key.php
	 */
	public function key() {
		return false;
	}

	/**
	 * Iterator::next — Return the next element
	 *
	 * @see Iterator::next()
	 * @link http://php.net/manual/en/iterator.next.php
	 */
	public function next() {
		if ($this->modify instanceof \DateInterval) {
			$this->start->add($this->modify);
		} else {
			$this->start->modify($this->modify);
		}
	}

	public function __destruct() {
		fclose($this->fileHandle);
	}
}

?>