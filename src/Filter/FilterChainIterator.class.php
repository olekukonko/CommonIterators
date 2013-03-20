<?php

namespace src;

/**
 * 
 * @author Oleku
 $filterMultiples = function($currentElement, $multipleOf)
{
    return $currentElement % $multipleOf !== 0;
};
$filterRange = function($currentElement, $from, $to)
{
    return $currentElement < $from  || $currentElement > $to;
};
$filterDoubleDigits = function($currentElement)
{
    return strlen($currentElement) == 1 ||
        count(count_chars($currentElement, 1)) > 1;
};

$iterator = new FilterChainIterator(new ArrayIterator(range(1, 100)));
$iterator->addCallback($filterMultiples, array(3))
         ->addCallback($filterMultiples, array(5))
         ->addCallback($filterMultiples, array(7))
         ->addCallback($filterRange, array(20,30))
         ->addCallback($filterRange, array(50,90))
         ->addCallback($filterDoubleDigits);

foreach($iterator as $number) {
    echo "$number,"; // 1,2,4,8,13,16,17,19,31,32,34,37,38,41,43,46,47,92,94,97,
}
 *
 */
class FilterChainIterator extends FilterIterator {
	/**
	 * Callback Store
	 * 
	 * @var Array
	 */
	protected $_callbacks = array();

	/**
	 * Adds a callback to the Iterator's callback store
	 *
	 * Callbacks registered through this method must accept the current
	 * element of the iteration as first argument. Any arguments given
	 * in the second optional argument $arguments will be passed to the
	 * callback as additional function arguments.
	 *
	 * @param Mixed $callback
	 *        	Anything callable
	 * @param Array $arguments
	 *        	Array of arguments for Callback
	 * @return s FilterChainIterator
	 * @throws InvalidArgumentException when $callback is not callable
	 */
	public function addCallback($callback, $arguments = array()) {
		if (! is_callable($callback)) {
			throw new InvalidArgumentException(sprintf('%s expects argument 1 to be callable', __FUNCTION__));
		}
		$this->_callbacks[] = array('function' => $callback,'arguments' => $arguments);
		
		return $this;
	}

	/**
	 * Returns the Callback Store
	 * 
	 * @return Array
	 */
	public function getCallbacks() {
		return $this->_callbacks;
	}

	/**
	 * Filters current element by each callback in the Callback Store
	 *
	 * @see FilterIterator::accept()
	 * @return Boolean
	 */
	public function accept() {
		foreach ( $this->getCallbacks() as $callback ) {
			$args = $this->_curryCallbackArguments($callback['arguments']);
			$accept = call_user_func_array($callback['function'], $args);
			if ($accept === FALSE) {
				return FALSE;
			}
		}
		return TRUE;
	}

	/**
	 * Prepends the arguments array with the current element
	 *
	 * @param array $arguments        	
	 * @return Array
	 */
	protected function _curryCallbackArguments(array $arguments) {
		return array_merge(array($this->current()), $arguments);
	}
}

?>