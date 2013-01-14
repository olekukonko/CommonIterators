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
	 * @param Iterator $it
	 */
	public function __construct(Iterator $it) {
		parent::__construct(array_reverse(iterator_to_array($it)));
	}
}

?>