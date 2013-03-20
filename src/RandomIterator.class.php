<?php

namespace src;

/**
 *
 * @author Oleku
 * @desc Generating Random Values using Fisher–Yates shuffle
 * @link http://en.wikipedia.org/wiki/Fisher%E2%80%93Yates_shuffle
 *      
 *      
 */
class RandomIterator implements \IteratorAggregate {
	protected $items = array();

	function __construct($it) {
		$this->items = $it instanceof \Traversable ? iterator_to_array($it) : $it;
		$items = &$this->items;
		
		for($i = count($items) - 1; $i > 0; $i --) {
			$j = @mt_rand(0, $i);
			$tmp = $items[$i];
			$items[$i] = $items[$j];
			$items[$j] = $tmp;
		}
	}

	function getIterator() {
		return $this->items;
	}
}

?>