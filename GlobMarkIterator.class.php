<?php

namespace Run;

use RecursiveDirectoryIterator ;
/**
 * 
 * @author Oleku
 * @link http://stackoverflow.com/a/12988571/1226894
 */
class GlobMarkIterator extends RecursiveDirectoryIterator {
    function current() {
        return $this->isDir() ? $this->getPathname() . "/" : $this->getPathname();
    }
}

?>