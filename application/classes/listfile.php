<?php
defined('SYSPATH') or die('No direct script access.');

class ListFile extends RecursiveIteratorIterator {

    protected $_path;
    public function __construct($path) {
        $this->_path = realpath($path);
        if (!$this->_path) {
            throw new InvalidArgumentException('The path is not a file or a direcotry');
        }
        
        parent::__construct(
            new RecursiveCachingIterator(
                    new RecursiveDirectoryIterator($this->_path, RecursiveIteratorIterator::SELF_FIRST
                    ),
                    CachingIterator::CALL_TOSTRING | CachingIterator::CATCH_GET_CHILD
            ),
            parent::SELF_FIRST
        );
    }

    public function __call($func, $params) {
        return call_user_func_array(array($this->getSubIterator(), $func), $params);
    }

    public function getPath() {
        return $this->_path;
    }

}


/*class ListFile extends RecursiveIteratorIterator
{
    protected $_path;
    public function  __construct($path, $mode = RecursiveIteratorIterator::SELF_FIRST, $flags = 0) {
        $this->_path = realpath($path);
        if (!$this->_path) {
            throw new InvalidArgumentException('The path is not a file or a direcotry');
        }

        parent::__construct(new RecursiveDirectoryIterator($this->_path), $mode, $flags);
    }

    public function getPath() {
        return $this->_path;
    }
}*/

?>
