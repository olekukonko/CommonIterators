<?php

namespace src;

class CustomFilterIterator extends FilterIterator
{
    private $filters = array();

    /**
     * Constructor.
     *
     * @param \Iterator $iterator The Iterator to filter
     * @param array     $filters  An array of PHP callbacks
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(\Iterator $iterator, array $filters)
    {
        foreach ($filters as $filter) {
            if (!is_callable($filter)) {
                throw new \InvalidArgumentException('Invalid PHP callback.');
            }
        }
        $this->filters = $filters;

        parent::__construct($iterator);
    }

    /**
     * Filters the iterator values.
     *
     * @return Boolean true if the value should be kept, false otherwise
     */
    public function accept()
    {
        $fileinfo = $this->current();

        foreach ($this->filters as $filter) {
            if (false === call_user_func($filter, $fileinfo)) {
                return false;
            }
        }

        return true;
    }
}

?>