<?php

namespace run\io;

use Iterator, RuntimeException, InvalidArgumentException;

class RandomLineIterator implements Iterator {
	protected $filename;
	protected $fileHandle;
	protected $line;
	protected $i;
	protected $n;
	protected $max ;
	protected $list ;
	
	/**
	 *
	 * @param string $fileName        	
	 * @throws RuntimeException
	 */
	public function __construct($fileName,$max = 0) {
		$this->filename = realpath((string) $fileName);
		$ths->max = $max; 
		$this->list = array();
		if (! is_file($this->filename))
			throw new InvalidArgumentException(sprintf("Can't open file %s", $this->filename));
		
		if (! $this->fileHandle = fopen($this->filename, 'r')) {
			throw new RuntimeException('Couldn\'t open file "' . $this->filename . '"');
		}
		
		$this->size = filesize($this->filename);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		fseek($this->fileHandle, 0);
		$this->line = $this->get();
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
			$this->line = $this->get();
			$this->i ++;
		}
	}

	public function __destruct() {
		fclose($this->fileHandle);
	}

	function get() {

			fseek($this->fileHandle, mt_rand(0, $this->size));
			fgets($this->fileHandle);
			$pos = ftell($this->fileHandle);
			isset($list[$pos]) or $s = trim(fgets($this->fileHandle)) and $list[$pos] = $s and $this->n ++;
			
			if ($this->n >= $this->max)
				return false ;

		return $list[$pos];
	}
}

?>