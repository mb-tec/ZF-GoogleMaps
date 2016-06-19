<?php

namespace MBtec\GoogleMaps\Resources;

use Zend\Stdlib\ArraySerializableInterface;

class LatLng implements ArraySerializableInterface
{
	/**
	 * @var float Latitude
	 */
	protected $lat;
	
	/**
	 * 
	 * @var float Longitude
	 */
	protected $lng;
	
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
	 * @return the $lat
	 */
	public function getLat() 
	{
		return $this->lat;
	}

	/**
	 * @return the $lng)
	 */
	public function getLng() 
	{
		return $this->lng;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\ArraySerializableInterface::exchange[]
	 * @throws Exception\InvalidArgumentException
	 */
	public function exchangeArray(array $data) 
	{
		if (isset($data['lat']) && is_numeric($data['lat'])) {
			$this->lat = $data['lat'];
		}
		if (isset($data['lng']) && is_numeric($data['lng'])) {
			$this->lng = $data['lng'];
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\ArraySerializableInterface::getArrayCopy()
	 */
	public function getArrayCopy() 
	{
		return array(
			'lat' => $this->lat,
			'lng' => $this->lng,
		);
	}
}
