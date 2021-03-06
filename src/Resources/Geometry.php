<?php

namespace MBtecZfGoogleMaps\Resources;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class        Geometry
 * @package     MBtecZfGoogleMaps\Resources
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Geometry implements ArraySerializableInterface
{
	const APPROXIMATE 		 = 'approximate';
	const GEOMETRIC_CENTER 	 = 'geometric_center';
	const RANGE_INTERPOLATED = 'range_interpolated';
	const ROOFTOP 			 = 'rooftop';
	
	protected $bounds;
	protected $location;
	protected $locationType;
	protected $viewport;
	
	public function __construct(array $data)
	{
		$this->exchangeArray($data);
	}
	
	/**
	 * @return the $bounds
	 */
	public function getBounds() 
	{
		return $this->bounds;
	}

	/**
	 * @return the $location
	 */
	public function getLocation() 
	{
		return $this->location;
	}

	/**
	 * @return the $locationType
	 */
	public function getLocationType() 
	{
		return $this->locationType;
	}

	/**
	 * @return the $viewport
	 */
	public function getViewport() 
	{
		return $this->viewport;
	}


	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\ArraySerializableInterface::exchange[]
	 */
	public function exchangeArray(array $data) 
	{
		if (isset($data['location']) && is_array($data['location'])) {
			$location = new LatLng($data['location']);
			$this->location = $location;
		}
		if (isset($data['viewport']) && is_array($data['viewport'])) {
			$viewport = new LatLngBounds($data['viewport']);
			$this->viewport = $viewport;
		}
		if (isset($data['bounds']) && is_array($data['bounds'])) {
			$bounds = new LatLngBounds($data['bounds']);
			$this->bounds = $bounds;
		}
		if (isset($data['location_type']) && is_string($data['location_type'])) {
			$this->locationType = $data['location_type'];
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\ArraySerializableInterface::getArrayCopy()
	 */
	public function getArrayCopy() 
	{
		return [
			'location' => $this->location->getArrayCopy(),
			'location_type' => $this->locationType,
			'viewport' => $this->viewport->getArrayCopy(),
			'bounds' => $this->bounds->getArrayCopy(),
		];
	}
}
