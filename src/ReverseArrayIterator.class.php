<?php

namespace run;

use ArrayIterator;

/**
 *
 * @author Oleku
 *        
 */
class ReverseArrayIterator extends ArrayIterator {
	
	/**
	 * 
	 * @param array $array
	 */
	public function __construct(array $array) {
		parent::__construct(array_reverse($array));
	}
}

?>