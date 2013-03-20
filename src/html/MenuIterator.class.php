<?php

if (!class_exists("RecursiveArrayIterator"))
{
    class RecursiveArrayIterator extends ArrayIterator implements RecursiveIterator
    {
        /** @return whether the current element has children
         */
        function hasChildren()
        {
            return is_array($this->current());
        }
    
        /** @return an iterator for the current elements children
         *
         * @note the returned iterator will be of the same class as $this
         */
        function getChildren()
        {
            if (empty($this->ref))
            {
                $this->ref = new ReflectionClass($this);
            }
            return $this->ref->newInstance($this->current());
        }
        
        private $ref;
    }
}

interface MenuItem 
{
    /** @return string representation of item (e.g. name/link)*/
    function __toString();
    
    /** @return whether item has children */
    function getChildren();
    
    /** @return children of the item if any available */
    function hasChildren();
    
    /** @return whether item is active or grayed */
    function isActive();
    
    /** @return whether item is visible or should be hidden */
    function isVisible();

    /** @return the name of the entry */
    function getName();
}

class Menu implements IteratorAggregate
{
    public $_ar = array(); // PHP does not support friend

    function addItem(MenuItem $item) {
        $this->_ar[$item->getName()] = $item;
        return $item;
    }
    function getIterator() {
        return new MenuIterator($this);
    }
}

class MenuIterator extends RecursiveArrayIterator
{
    function __construct(Menu $menu) {
        parent::__construct($menu->_ar);
    }
    function hasChildren() {
        return $this->current()->hasChildren();
    }
}

class MenuEntry implements MenuItem
{
    protected $name, $link, $active, $visible;

    function __construct($name, $link = NULL) {
        $this->name = $name;
        $this->link = is_numeric($link) ? NULL : $link;
        $this->active = true;
        $this->visible = true;
    }
    function __toString() {
        if (strlen($this->link)) {
            return '<a href="'.$this->link.'">'.$this->name.'</a>';
        } else {
            return $this->name;
        }
    }
    function hasChildren() { return false; }
    function getChildren() { return NULL; }
    function isActive()    { return $this->active; }
    function isVisible()   { return $this->visible; }
    function getName()     { return $this->name; }
}

class SubMenu extends Menu implements MenuItem
{
    protected $name, $link, $active, $visible;

    function __construct($name = NULL, $link = NULL) {
        $this->name = $name;
        $this->link = is_numeric($link) ? NULL : $link;
        $this->active = true;
        $this->visible = true;
    }
    function __toString() {
        if (strlen($this->link)) {
            return '<a href="'.$this->link.'">'.$this->name.'</a>';
        } else if (strlen($this->name)) {
            return $this->name;
        } else return '';
    }
    function hasChildren() { return true; }
    function getChildren() { return new MenuIterator($this); }
    function isActive()    { return $this->active; }
    function isVisible()   { return $this->visible; }
    function getName()     { return $this->name; }
}

class MenuLoadArray extends RecursiveIteratorIterator {
    protected $sub = array();

    function __construct(Menu $menu, Array $def) {
        $this->sub[0] = $menu;
        parent::__construct(new RecursiveArrayIterator($def, self::LEAVES_ONLY));
    }

    function callGetChildren() {
        $child = parent::callGetChildren();
        $this->sub[] = end($this->sub)->addItem(new SubMenu());
        return $child;
    }

    function endChildren() {
        array_pop($this->sub);
    }

    function nextElement() {
        end($this->sub)->addItem(new MenuEntry($this->current(), $this->key()));
    }
}

class MenuOutput extends RecursiveIteratorIterator
{
    function __construct($ar) {
        parent::__construct($ar);
    }

    function beginChildren() {
        echo str_repeat('&nbsp;',$this->getDepth())."<ul>\n";
    }

    function endChildren() {
        echo str_repeat('&nbsp;',$this->getDepth())."</ul>\n";
    }
}

$def = array('1', '2', array('31', '32'), '4');

if (1)
{
    echo "Using MenuLoadArray\n";

    $menu = new Menu();
    foreach(new MenuLoadArray($menu, $def) as $v);
}
else
{
    echo "Using RecursiveArrayIterator\n";

    $menu = new RecursiveArrayIterator($def);
}

$it = new MenuOutput($menu);
echo "<ul>\n"; // for the intro

foreach($it as $m) {
    echo str_repeat('&nbsp;',$it->getDepth()+1),"<li>",$m,"</li>\n";
}

echo "</ul>\n"; // for the outro

?>