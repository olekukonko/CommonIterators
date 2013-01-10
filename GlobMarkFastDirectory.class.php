<?php

namespace Run;

use RecursiveDirectoryIterator;
/**
 *
 * @author Oleku
 * @link http://stackoverflow.com/a/12988571/1226894
 */
class GlobMarkFastDirectory extends RecursiveDirectoryIterator {

	function current() {
		return dirname($this->getPathname()) . "/";
	}
}

?>