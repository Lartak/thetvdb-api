<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 23:03
 */

namespace TheTvDb\Model\Common;


use Traversable;

/**
 * Class GenericCollection
 *
 * @package TheTvDb\Model\Common
 */
class GenericCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * GenericCollection constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data = [])
	{
		$this->data = $data;
	}
	/**
	 * @return array
	 */
	public function toArray()
	{
		return $this->data;
	}
	/**
	 * Removes all key value pairs
	 *
	 * @return GenericCollection
	 */
	public function clear()
	{
		$this->data = [];
		return $this;
	}
	/**
	 * Get all or a subset of matching key value pairs
	 *
	 * @param array $keys Pass an array of keys to retrieve only a subset of key value pairs
	 *
	 * @return array Returns an array of all matching key value pairs
	 */
	public function getAll(array $keys = null)
	{
		return $keys ? array_intersect_key($this->data, array_flip($keys)) : $this->data;
	}
	/**
	 * Get a specific key value.
	 *
	 * @param string $key Key to retrieve.
	 *
	 * @return mixed|null Value of the key or NULL
	 */
	public function get($key)
	{
		if (is_object($key)) {
			/** @var object $key */
			$key = spl_object_hash($key);
		}
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}
	/**
	 * Set a key value pair
	 *
	 * @param string $key   Key to set
	 * @param mixed  $value Value to set
	 *
	 * @return GenericCollection Returns a reference to the object
	 */
	public function set($key, $value)
	{
		if (is_null($key) && is_object($value)) {
			$key = spl_object_hash($value);
		}
		$this->data[$key] = $value;
		return $this;
	}
	/**
	 * Add a value to a key.
	 *
	 * @param string $key   Key to add
	 * @param mixed  $value Value to add to the key
	 *
	 * @return GenericCollection Returns a reference to the object.
	 */
	public function add($key, $value)
	{
		if (is_null($key) && is_object($value)) {
			$key = spl_object_hash($value);
		}
		if (!array_key_exists($key, $this->data) && !is_null($key)) {
			$this->data[$key] = $value;
		} elseif (!array_key_exists($key, $this->data) && is_null($key)) {
			$this->data[] = $value;
		} elseif (is_array($this->data[$key])) {
			$this->data[$key][] = $value;
		} else {
			$this->data[$key] = [$this->data[$key], $value];
		}
		return $this;
	}
	/**
	 * Remove a specific key value pair
	 *
	 * @param string $key A key to remove or an object in the same state
	 *
	 * @return GenericCollection
	 */
	public function remove($key)
	{
		if (is_object($key)) {
			/** @var object $key */
			$key = spl_object_hash($key);
		}
		unset($this->data[$key]);
		return $this;
	}
	/**
	 * Get all keys in the collection
	 *
	 * @return array
	 */
	public function getKeys()
	{
		return array_keys($this->data);
	}
	/**
	 * Returns whether or not the specified key is present.
	 *
	 * @param string $key The key for which to check the existence.
	 *
	 * @return bool
	 */
	public function hasKey($key)
	{
		return array_key_exists($key, $this->data);
	}
	/**
	 * Case insensitive search the keys in the collection
	 *
	 * @param string $key Key to search for
	 *
	 * @return bool|string Returns false if not found, otherwise returns the key
	 */
	public function keySearch($key)
	{
		foreach (array_keys($this->data) as $k) {
			if (!strcasecmp($k, $key)) {
				return $k;
			}
		}
		return false;
	}
	/**
	 * Checks if any keys contains a certain value
	 *
	 * @param string $value Value to search for
	 *
	 * @return mixed Returns the key if the value was found FALSE if the value was not found.
	 */
	public function hasValue($value)
	{
		return array_search($value, $this->data);
	}
	/**
	 * Replace the data of the object with the value of an array
	 *
	 * @param array $data Associative array of data
	 *
	 * @return GenericCollection Returns a reference to the object
	 */
	public function replace(array $data)
	{
		$this->data = $data;
		return $this;
	}
	/**
	 * Add and merge in a Collection or array of key value pair data.
	 *
	 * @param GenericCollection|array $data Associative array of key value pair data
	 *
	 * @return GenericCollection Returns a reference to the object.
	 */
	public function merge($data)
	{
		foreach ($data as $key => $value) {
			$this->add($key, $value);
		}
		return $this;
	}
	/**
	 * Returns a Collection containing all the elements of the collection after applying the callback function to each
	 * one. The Closure should accept three parameters: (string) $key, (string) $value, (array) $context and return a
	 * modified value
	 *
	 * @param \Closure $closure Closure to apply
	 * @param array    $context Context to pass to the closure
	 * @param bool     $static  Set to TRUE to use the same class as the return rather than returning a Collection
	 *
	 * @return GenericCollection
	 */
	public function map(\Closure $closure, array $context = [], $static = true)
	{
		$collection = $static ? new static() : new self();
		foreach ($this as $key => $value) {
			$collection->add($key, $closure($key, $value, $context));
		}
		return $collection;
	}
	/**
	 * Iterates over each key value pair in the collection passing them to the Closure. If the  Closure function returns
	 * true, the current value from input is returned into the result Collection.  The Closure must accept three
	 * parameters: (string) $key, (string) $value and return Boolean TRUE or FALSE for each value.
	 *
	 * @param \Closure $closure Closure evaluation function
	 * @param bool     $static  Set to TRUE to use the same class as the return rather than returning a Collection
	 *
	 * @return GenericCollection
	 */
	public function filter(\Closure $closure, $static = true)
	{
		$collection = ($static) ? new static() : new self();
		foreach ($this->data as $key => $value) {
			if ($closure($key, $value)) {
				$collection->add($key, $value);
			}
		}
		return $collection;
	}
	/**
	 * Allows sorting the current collection.
	 *
	 * For example:
	 *
	 * $person->sort(function ($a, $b) {
	 *   if ($a->getReleaseDate() == $b->getReleaseDate()) {
	 *     return 0;
	 *   }
	 *
	 *   return $a->getReleaseDate() < $b->getReleaseDate() ? 1 : -1;
	 * });
	 *
	 *
	 * @param \Closure $closure
	 * @return $this
	 */
	public function sort(\Closure $closure)
	{
		uasort($this->data, $closure);
		return $this;
	}
	/**
	 * Filter by id
	 *
	 * @param  integer           $id
	 * @return GenericCollection
	 */
	public function filterId($id)
	{
		if (1 === count($this->data)) {
			return array_shift($this->data);
		}
		$result = $this->filter(
			function ($key, $value) use ($id) {
				if ($value->getId() == $id) {
					return true;
				}
				return $this->data[$key];
			}
		);
		if (!count($result)) {
			return null;
		}
		$collection = $result->getAll();
		return array_shift($collection);
	}

	/**
	 * Retrieve an external iterator
	 *
	 * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->data);
	}

	/**
	 * Whether a offset exists
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}

	/**
	 * Offset to retrieve
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet($offset)
	{
		return isset($this->data[$offset]) ? $this->data[$offset] : null;
	}

	/**
	 * Offset to set
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet($offset, $value)
	{
		$this->data[$offset] = $value;
	}

	/**
	 * Offset to unset
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset)
	{
		unset($this->data[$offset]);
	}

	/**
	 * Count elements of an object
	 *
	 * @link https://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 * @since 5.1.0
	 */
	public function count()
	{
		return count($this->data);
	}
}