<?php

namespace run\filter;

use \run\io\CSVIterator ;
/**
 *
 * @author Oleku
 * @link http://stackoverflow.com/a/13558050/1226894
 */
class CSVIFilterterator extends \FilterIterator {
	protected $filter = array();
	protected $errors = array();

	/**
	 *
	 * @param \run\io\CSVIterator $iterator        	
	 */
	public function __construct(CSVIterator $iterator) {
		parent::__construct($iterator);
	}

	/**
	 * Add Filter to each colum of the CSV file
	 *
	 * @param int $index        	
	 * @param Callable $callable        	
	 */
	public function addFilter($index, Callable $callable) {
		$this->filter[$index] = $callable;
		$this->errors[$callable] = 0;
	}

	/**
	 * Get Errors
	 *
	 * @return multitype:
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * FilterIterator::accept — Check whether the current element of the
	 * iterator is acceptable
	 *
	 * @see FilterIterator::accept()
	 * @link http://php.net/manual/en/filteriterator.accept.php
	 */
	public function accept() {
		$line = $this->getInnerIterator()->current();
		$x = true;
		foreach ( $this->filter as $key => $var ) {
			if (isset($line[$key])) {
				$func = $this->filter[$key];
				$func($var) or $this->errors[$func] ++ and $x = false;
			}
		}
		return $x;
	}
}
?>