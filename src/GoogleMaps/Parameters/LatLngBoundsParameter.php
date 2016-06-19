<?php

namespace MBtec\GoogleMaps\Parameters;

use MBtec\GoogleMaps\Resources\LatLngBounds;
use MBtec\GoogleMaps\Exception\InvalidArgumentException;

/**
 * Class        LatLngBoundsParameter
 * @package     MBtec\GoogleMaps\Parameters
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class LatLngBoundsParameter implements ParameterInterface
{
	/**
	 * Bound box
	 * 
	 * @var LatLngBounds
	 */
	protected $latLngBounds;

    /**
     * @param LatLngBounds $latLngBounds
     */
    public function __construct(LatLngBounds $latLngBounds)
	{
		if (null === $latLngBounds) {
			throw new InvalidArgumentException('latLngBounds');
		}
		$this->latLngBounds = $latLngBounds;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \GoogleMaps\Parameters\ParameterInterface::toString()
	 */
	public function toString() 
	{
		return $this->latLngBounds->getSouthwest()->toString() . '|' . $this->latLngBounds->getNortheast()->toString();
	}
}
