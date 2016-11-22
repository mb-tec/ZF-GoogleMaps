<?php

namespace MBtecZfGoogleMaps\Resources;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class        LatLngBounds
 * @package     MBtecZfGoogleMaps\Resources
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class LatLngBounds implements ArraySerializableInterface
{
	/**
	 * @var LatLng SouthWest coordinates
	 */
	protected $southwest;
	
	/**
	 * 
	 * @var LatLng NorthEast coordinates
	 */
	protected $northeast;
	
	/**
	 * Constructor
	 * 
	 * @param array $data
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct(array $data)
	{
		$this->exchangeArray($data);
	}
	
	/**
	 * @return the $southwest
	 */
	public function getSouthwest()
	{
		if (null === $this->southwest) {
			$this->southwest = new LatLng();
		}
		return $this->southwest;
	}

	/**
	 * @return the $northeast
	 */
	public function getNortheast() 
	{
		if (null === $this->northeast) {
			$this->northeast = new LatLng();
		}
		return $this->northeast;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\ArraySerializableInterface::exchange[]
	 * @throws Exception\InvalidArgumentException
	 */
	public function exchangeArray(array $data) 
	{
		if (isset($data['southwest']) && is_array($data['southwest'])) {
			$southwest = new LatLng($data['southwest']);
			$this->southwest = $southwest;
		}
		if (isset($data['northeast']) && is_array($data['northeast'])) {
			$northeast = new LatLng($data['northeast']);
			$this->northeast = $northeast;	
		}
	}

	/* (non-PHPdoc)
	 * @see \Zend\Stdlib\ArraySerializableInterface::getArrayCopy()
	 */
	public function getArrayCopy() 
	{
		return array(
			'southwest' => $this->southwest->getArrayCopy(),
			'northeast' => $this->northeast->getArrayCopy(),
		);
	}
}
