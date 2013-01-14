<?php

namespace Run;

use FilesystemIterator, RecursiveFilterIterator, Run\GlobMarkIterator, InvalidArgumentException;

/**
 *
 * @author Oleku
 * @link http://stackoverflow.com/a/12988571/1226894
 */
class GlobMarkDirectory extends RecursiveFilterIterator {

	/**
	 * 
	 * @param string $path
	 * @throws InvalidArgumentException
	 */
	public function __construct($path) {
		if (! is_dir($path)) {
			throw new InvalidArgumentException(sprintf('path must be valid sirectory (%s given).', $path));
		}
		parent::__construct(new GlobMarkIterator($path, FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
	}

	/**
	 * FilterIterator::accept — Check whether the current element of the iterator is acceptable
	 * @see RecursiveFilterIterator::accept()
	 * @link http://php.net/manual/en/filteriterator.accept.php
	 */
	public function accept() {
		return $this->getInnerIterator()->isDir();
	}

	public function getChildren() {
		return new GlobMarkDirectory($this->getInnerIterator()->getPathname());
	}
}

?>