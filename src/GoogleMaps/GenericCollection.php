<?php

namespace MBtec\GoogleMaps;

use MBtec\GoogleMaps\Exception\InvalidArgumentException;
use MBtec\GoogleMaps\Exception\OutOfBoundsException;

/**
 * Class        GenericCollection
 * @package     MBtec\GoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
abstract class GenericCollection implements  \Countable, \Iterator, \ArrayAccess
{
	/**
	 * @var array
	 */
	protected $collection = [];
	
	/**
	 * @var string 
	 */
	protected $class;
	
	/**
	 * @var int
	*/
	protected $iteratorIndex = 0;

	/**
	 * GenericCollection constructor.
	 *
	 * @param $class
	 */
	public function __construct($class)
	{
		if (!class_exists($class)) {
			throw new InvalidArgumentException('class');
		}
		$this->class = $class;
	}

	/**
	 * @param $list
	 */
	public function initializeFromArray($list)
	{
		foreach ($list as $element) {
			$this->addElement($element);
		}
	}
	
	/**
	 * Add an element
	 *
	 * @param  mixed $element
	 * @return GenericCollection
	 */
	public  function addElement($element)
	{
		if (!$element instanceof $this->class) {
			throw new InvalidArgumentException('element');
		}
		$this->collection[] = $element;
		return $this;
	}
	
	/**
	 * Return the number of elements
	 * 
	 * Implement Countable::count()
	 * 
	 * @return int
	 */
	public function count()
	{
		return count($this->collection);
	}
	
	/**
	 * Return the current element
	 *
	 * Implement Iterator::current()
	 *
	 * @return mixed
	 */
	public function current()
	{
		return $this->collection[$this->iteratorIndex];
	}
	
	/**
	 * Return the key of the current element
	 *
	 * Implement Iterator::key()
	 *
	 * @return int
	 */
	public function key()
	{
		return $this->iteratorIndex;
	}
	
	/**
	 * Move forward to next element
	 *
	 * Implement Iterator::next()
	 *
	 * @return void
	 */
	public function next()
	{
		$this->iteratorIndex += 1;
	}
	
	/**
	 * Rewind the Iterator to the first element
	 *
	 * Implement Iterator::rewind()
	 *
	 * @return void
	 */
	public function rewind()
	{
		$this->iteratorIndex = 0;
	}
	
	/**
	 * Check if there is a current element after calls to rewind() or next()
	 *
	 * Implement Iterator::valid()
	 *
	 * @return bool
	 */
	public function valid()
	{
		$count = $this->count();
		if ($count > 0 && $this->iteratorIndex < $count) {
			return true;
		}
		return false;
	}
	
	/**
	 * Whether the offset exists
	 *
	 * Implement ArrayAccess::offsetExists()
	 *
	 * @param   int     $offset
	 * @return  bool
	 */
	public function offsetExists($offset)
	{
		return ($offset < $this->count());
	}
	
	/**
	 * Return value at given offset
	 *
	 * Implement ArrayAccess::offsetGet()
	 *
	 * @param  int $offset
	 * @throws Exception\OutOfBoundsException
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		if (!$this->offsetExists($offset)) {
			throw new OutOfBoundsException('Out of bounds index');
		}
		return $this->collection[$offset];
	}
	
	/**
	 * Set value at given offset
	 *
	 * Implement ArrayAccess::offsetSet()
	 *
	 * @param  int   $offset
	 * @param  mixed $value
	 * @throws Exception\RuntimeException
	 */
	public function offsetSet($offset, $value)
	{
		if (!$this->offsetExists($offset)) {
			throw new OutOfBoundsException('Out of bounds index');
		}
		$this->collection[$offset] = $value;
	}
	
	/**
	 * Unset value at given offset
	 *
	 * Implement ArrayAccess::offsetUnset()
	 *
	 * @param  int $offset
	 * @throws Exception\RuntimeException
	 */
	public function offsetUnset($offset)
	{
		if (!$this->offsetExists($offset)) {
			throw new OutOfBoundsException('Out of bounds index');
		}
		unset($this->collection[$offset]);
	}
}
