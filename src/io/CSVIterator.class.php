<?php

namespace run\io;

use Iterator, RuntimeException, InvalidArgumentException;

/**
 *
 * @author Oleku
 *        
 */
class CSVIterator implements Iterator {
	protected $filename;
	protected $length;
	protected $delimiter;
	protected $enclosure;
	protected $escape;
	protected $fileHandle;
	protected $line;
	protected $i;

	/**
	 *
	 * @param string $fileName        	
	 * @throws RuntimeException
	 */
	public function __construct($fileName, $length = 0, $delimiter = ",", $enclosure = '"', $escape = '\\') {
		$this->filename = realpath((string) $fileName);
		$this->length = (int) $length;
		$this->delimiter = (string) $delimiter;
		$this->enclosure = (string) $enclosure;
		$this->escape = (string) $escape;
		
		if (! is_file($this->filename))
			throw new InvalidArgumentException(sprintf("Can't open file %s", $this->filename));
		
		if (! $this->fileHandle = fopen($this->filename, 'r')) {
			throw new RuntimeException('Couldn\'t open file "' . $this->filename . '"');
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

	/**
	 * Iterator::valid — Checks if current position is valid
	 *
	 * @see Iterator::valid()
	 * @link http://php.net/manual/en/iterator.valid.php
	 */
	public function valid() {
		return false !== $this->line;
	}

	/**
	 * Iterator::current — Return the current element
	 *
	 * @see Iterator::current()
	 * @link http://php.net/manual/en/iterator.current.php
	 */
	public function current() {
		return $this->line;
	}

	/**
	 * Iterator::key — Return the key element
	 *
	 * @see Iterator::key()
	 * @link http://php.net/manual/en/iterator.key.php
	 */
	public function key() {
		return $this->i;
	}

	/**
	 * Iterator::next — Return the next element
	 *
	 * @see Iterator::next()
	 * @link http://php.net/manual/en/iterator.next.php
	 */
	public function next() {
		if (false !== $this->line) {
			$this->line = fgetcsv($this->fileHandle, $this->length, $this->delimiter, $this->enclosure, $this->escape);
			$this->i ++;
		}
	}

	public function __destruct() {
		fclose($this->fileHandle);
	}
}

?>