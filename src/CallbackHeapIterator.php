<?php

namespace src;

use SplHeap , InvalidArgumentException;

class CallbackHeapIterator extends SplHeap {
	private $callback;

	/**
	 * 
	 * @param Callable $callback
	 * @throws InvalidArgumentException
	 */
	function __construct(Callable $callback) {
		if (! is_callable($callback)) {
			throw new InvalidArgumentException(sprintf('Callback must be callable (%s given).', $callback));
		}
		
		$this->callback = $callback;
	}

	public function compare($a, $b) {
		return $this->callback($a, $b);
	}
}
?>