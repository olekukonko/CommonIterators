<?php

namespace run;

class InwardIterator implements \IteratorAggregate {
	private $position = 0;
	private $list;

	public function __construct($array, $id, $parentID) {
		$this->position = 0;
	}

	public function getIterator() {
		// TODO Auto-generated method stub
	}
}

