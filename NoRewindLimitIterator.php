<?php

namespace Run;
use IteratorIterator;

/**
 * 
 * @author Oleku
 *
 */
class NoRewindLimitIterator extends IteratorIterator
{
	private $start, $count, $next;
	
	public function __construct($it, $start, $count) {
		parent::__construct($it);
		$this->start = max(0, $start);
		$this->count = max(0, $count);
	}
	
	public function rewind() {
	    $start = $this->start;
		while($start--) {
			parent::next();
		}
		$this->next = 0;
	}
	
	public function next() {
		parent::next();
		$this->next++;		
	}
	
	public function valid() {
		if (!parent::valid()) return false;
		return $this->next < $this->count;
		
	}
}

?>