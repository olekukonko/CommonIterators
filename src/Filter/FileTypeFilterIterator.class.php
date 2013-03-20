<?php

namespace Run;
use FilterIterator ;
/**
 *
 * @author Oleku
 *        
 */
class FileTypeFilterIterator extends FilterIterator {
	const ONLY_FILES = 1;
	const ONLY_DIRECTORIES = 2;
	private $mode;

	/**
	 * Constructor.
	 *
	 * @param \Iterator $iterator
	 *        	The Iterator to filter
	 * @param integer $mode
	 *        	The mode (self::ONLY_FILES or self::ONLY_DIRECTORIES)
	 */
	public function __construct(\Iterator $iterator, $mode) {
		$this->mode = $mode;
		
		parent::__construct($iterator);
	}

	/**
	 * Filters the iterator values.
	 *
	 * @return Boolean true if the value should be kept, false otherwise
	 */
	public function accept() {
		$fileinfo = $this->current();
		if (self::ONLY_DIRECTORIES === (self::ONLY_DIRECTORIES & $this->mode) && $fileinfo->isFile()) {
			return false;
		} elseif (self::ONLY_FILES === (self::ONLY_FILES & $this->mode) && $fileinfo->isDir()) {
			return false;
		}
		
		return true;
	}
}
?>