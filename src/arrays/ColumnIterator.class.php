<?php

namespace run\arrays;
use MultipleIterator, ArrayIterator, Traversable;


/**
 *
 * @author Oleku
 * @link http://stackoverflow.com/a/14263157/1226894
 * 
 */
class ColumnIterator extends MultipleIterator {
	function __construct(Traversable $multi, $flags = null) {
		parent::__construct($flags ?  : self::MIT_NEED_ANY | self::MIT_KEYS_ASSOC);
		foreach ( $multi as $k => $v ) {
			$this->attachIterator(new ArrayIterator($v), $k);
		}
	}
}

?>