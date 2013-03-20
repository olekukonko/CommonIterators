<?php

namespace Run\Filter;

use FilterIterator, InvalidArgumentException;

/**
 *
 * @author Oleku
 * @example $skip = new SkipIterator(new ArrayIterator(range(1, 100)),
 *          SkipIterator::SKIP_COUNT,10});
 *          echo "<pre>";
 *          foreach ( $skip as $v ) {
 *          echo $v, PHP_EOL;
 *          }
 */
class Skip extends FilterIterator {
	const SKIP_COUNT = 1;
	const SKIP_CALLBACK = 2;
	private $count;
	private $type;
	private $arg;

	/**
	 *
	 * @param \Iterator $iterator        	
	 * @param int $type        	
	 * @param mixed $arg        	
	 */
	function __construct(\Iterator $iterator, $type, $arg) {
		parent::__construct($iterator);
		$this->type = $type;
		$this->arg = $arg;
	}

	/**
	 * FilterIterator::accept — Check whether the current element of the
	 * iterator is acceptable
	 *
	 * @see FilterIterator::accept()
	 * @link http://php.net/manual/en/filteriterator.accept.php
	 */
	function accept() {
		switch ($this->type) {
			case self::SKIP_COUNT :
				$this->count ++;
				if ($this->count >= $this->arg || $this->count == 0) {
					$this->count = 0;
					return true;
				}
				break;
			
			case self::SKIP_CALLBACK :
				if (! is_callable($this->arg)) {
					throw new InvalidArgumentException("Argument must be callable");
				}
				return call_user_func($this->arg, $this->current());
				break;
		}
		
		return false;
	}
}

?>