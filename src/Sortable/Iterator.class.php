<?php

namespace Run\Sortable;

use ArrayIterator, InvalidArgumentException;

class Iterator extends ArrayIterator {

	/**
	 *
	 * @param Traversable $iterator        	
	 * @param mixed $callback        	
	 * @throws InvalidArgumentException
	 */
	public function __construct(\Traversable $iterator, $callback) {
		if (! is_callable($callback)) {
			throw new InvalidArgumentException(sprintf('Callback must be callable (%s given).', $callback));
		}
		parent::__construct(iterator_to_array($iterator));
		$this->uasort($callback);
	}
}
?>