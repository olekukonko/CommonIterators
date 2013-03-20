<?php

namespace Run\File;

	/**
	 * 
	 * @author Oleku
	 * @link http://stackoverflow.com/a/14417015/1226894
	 */
	class FileDepthFilterIterator extends FilterIterator {
		private $it;
		private $depth;
		private $type;
		const ONLY_DIR = 1;
		const ONLY_FILE = 2;
		const BOTH_DIR_FILE = 3;
	
		function __construct(RecursiveIteratorIterator &$iterator, $depth, $type) {
			$this->it = &$iterator;
			$this->depth = $depth;
			$this->type = $type;
			parent::__construct($this->it);
		}
	
		function accept() {
			if ($this->getDepth() != $this->depth) {
				return false;
			}
			if ($this->type == self::ONLY_DIR && ! $this->getInnerIterator()->current()->isDir()) {
				return false;
			}
			if ($this->type == self::ONLY_FILE && ! $this->getInnerIterator()->current()->isFile()) {
				return false;
			}
			
			return true;
		}
	}
?>