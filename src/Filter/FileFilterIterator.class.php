<?php

namespace Run;

use FilterIterator, Iterator;

class FileFilterIterator extends FilterIterator {

	public function __construct(Iterator $iterator) {
		parent::__construct($iterator);
	}

	public function accept() {
	}
}

?>