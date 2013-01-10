<?php

namespace Run;

use FilesystemIterator, RecursiveFilterIterator, Run\GlobMarkIterator;
/**
 *
 * @author Oleku
 * @link http://stackoverflow.com/a/12988571/1226894
 */
class GlobMarkDirectory extends RecursiveFilterIterator {

	public function __construct($path) {
		parent::__construct(new GlobMarkIterator($path, FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
	}

	public function accept() {
		return $this->getInnerIterator()->isDir();
	}

	public function getChildren() {
		return new GlobMarkDirectory($this->getInnerIterator()->getPathname());
	}
}

?>