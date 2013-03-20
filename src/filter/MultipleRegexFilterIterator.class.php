<?php

namespace run\filter;

/**
 * MultiplePcreFilterIterator filters files using patterns (regexps, globs or
 * strings).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class MultiplePcreFilterIterator extends FilterIterator {
	protected $matchRegexps;
	protected $noMatchRegexps;

	/**
	 * Constructor.
	 *
	 * @param \Iterator $iterator
	 *        	The Iterator to filter
	 * @param array $matchPatterns
	 *        	An array of patterns that need to match
	 * @param array $noMatchPatterns
	 *        	An array of patterns that need to not match
	 */
	public function __construct(\Iterator $iterator, array $matchPatterns, array $noMatchPatterns) {
		$this->matchRegexps = array();
		foreach ( $matchPatterns as $pattern ) {
			$this->matchRegexps[] = $this->toRegex($pattern);
		}
		
		$this->noMatchRegexps = array();
		foreach ( $noMatchPatterns as $pattern ) {
			$this->noMatchRegexps[] = $this->toRegex($pattern);
		}
		
		parent::__construct($iterator);
	}

	/**
	 * Checks whether the string is a regex.
	 *
	 * @param string $str        	
	 *
	 * @return Boolean Whether the given string is a regex
	 */
	protected function isRegex($str) {
		return Expression::create($str)->isRegex();
	}

	/**
	 * Converts string into regexp.
	 *
	 * @param string $str
	 *        	Pattern
	 *        	
	 * @return string regexp corresponding to a given string
	 */
	abstract protected function toRegex($str);
}
?>