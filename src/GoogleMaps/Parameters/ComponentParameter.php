<?php

namespace MBtec\GoogleMaps\Parameters;

/**
 * Class        ComponentParameter
 * @package     MBtec\GoogleMaps\Parameters
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class ComponentParameter implements ParameterInterface
{
	const ROUTE 			  = 'route';
	const LOCALITY 			  = 'locality';
	const ADMINISTRATIVE_AREA = 'administrative_area';
	const POSTAL_CODE 		  = 'postal_code';
	const COUNTRY			  = 'country'; 
	
	/**
	 * Filter key
	 * 
	 * @var string
	 */
	protected $key;
	
	/**
	 * Filter value
	 * 
	 * @var string
	 */
	protected $value;
	
	/**
	 * Constructor
	 * 
	 * @param  string $key
	 * @param  string $value
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct($key, $value)
	{
		$validFilters = array(
				self::ROUTE,
				self::LOCALITY,
				self::ADMINISTRATIVE_AREA,
				self::POSTAL_CODE,
				self::COUNTRY,
		);
		if (!in_array($key, $validFilters)) {
			throw new Exception\InvalidArgumentException('key');	
		}
		
		$this->key = $key;
		$this->value = $value;
	}
	
	/**
	 * @return the $key
	 */
	public function getKey() 
	{
		return $this->key;
	}

	/**
	 * @return the $value
	 */
	public function getValue() 
	{
		return $this->value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \GoogleMaps\Parameters\ParameterInterface::toString()
	 */
	public function toString()
	{
		return $this->key . '|' . $this->value();
	}
}
