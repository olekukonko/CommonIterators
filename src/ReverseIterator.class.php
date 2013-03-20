<?php

namespace Run;

use ArrayIterator, Iterator;

/**
 *
 * @author Oleku
 *        
 */
class ReverseIterator extends ArrayIterator {
	/**
	 *
	 * @param mixed $it        	
	 */
	public function __construct($it) {
		$it = $it instanceof \Traversable ? iterator_to_array($it) : $it;
		parent::__construct(array_reverse($it));
	}
}

?>