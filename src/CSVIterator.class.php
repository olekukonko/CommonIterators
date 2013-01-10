<?php

namespace Run;

use Iterator, RuntimeException;

/**
 *
 * @author Oleku
 *        
 */
class CSVIterator implements Iterator {
	protected $fileHandle;
	protected $line;
	protected $i;

	public function __construct($fileName) {
		if (! $this->fileHandle = fopen($fileName, 'r')) {
			throw new RuntimeException('Couldn\'t open file "' . $fileName . '"');
		}
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		fseek($this->fileHandle, 0);
		$this->line = fgetcsv($this->fileHandle);
		$this->i = 0;
	}

	public function valid() {
		return false !== $this->line;
	}

	public function current() {
		return $this->line;
	}

	public function key() {
		return $this->i;
	}

	public function next() {
		if (false !== $this->line) {
			$this->line = fgetcsv($this->fileHandle);
			$this->i ++;
		}
	}

	public function __destruct() {
		fclose($this->fileHandle);
	}
}

?>