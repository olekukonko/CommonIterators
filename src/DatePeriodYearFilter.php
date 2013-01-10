<?php

namespace Run;

use  FilterIterator , IteratorIterator ;
/*
 * Get all 52 weeks of the year and work days given the first day of the January of current year
 * @link http://stackoverflow.com/a/14147613/367456 
 * @author hakre <http://hakre.wordpress.com/credits>
 */
 
/**
 * Filter a DatePeriod by year
 */
class DatePeriodYearFilter extends FilterIterator
{
    private $year;
 
    public function __construct(DatePeriod $period, $year) {
 
        $this->year = $year;
        parent::__construct(new IteratorIterator($period));
    }
 
    public function accept() {
 
        return $this->current()->format('Y') == $this->year;
    }
}
?>