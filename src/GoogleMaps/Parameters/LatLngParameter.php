<?php

namespace MBtec\GoogleMaps\Parameters;

use MBtec\GoogleMaps\Resources\LatLng;

/**
 * Class        LatLngParameter
 * @package     MBtec\GoogleMaps\Parameters
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class LatLngParameter implements ParameterInterface
{
	/**
	 * Latitude/longitude
	 * 
	 * @var LatLng
	 */
	protected $latLng;
	
	/**
	 * Constructor
	 * 
	 * @param LatLng $latLng
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct(LatLng $latLng)
	{
		if (null === $latLng) {
			throw new Exception\InvalidArgumentException('latLng');
		}
		$this->latLng = $latLng;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \GoogleMaps\Parameters\ParameterInterface::toString()
	 */
	public function toString() 
	{
		$lat = str_replace(',', '.', $this->latLng->getLat());
        $lon = str_replace(',', '.', $this->latLng->getLng());

        return $lat . ',' . $lon;
	}
}
