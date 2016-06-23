<?php

namespace MBtecZfGoogleMaps;

use MBtecZfGoogleMaps\Parameters\ComponentSetParameter;
use MBtecZfGoogleMaps\Parameters\LatLngBoundsParameter;
use MBtecZfGoogleMaps\Parameters\LatLngParameter;

/**
 * Class        Request
 * @package     MBtecZfGoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Request
{
	const SENSOR = 'true';
	const NO_SENSOR = 'false';
	
	/**
	 * Address to perform geocoding (required)
	 * 
	 * @var string
	 */
	protected $_address;
	
	/**
	 * Latitude / longitude to perform reverse geocoding (required)
	 * 
	 * @var LatLng
	 */
	protected $_latLng;
	
	/**
	 * Components filter to perform geocoding (optional if an address is provided else required)
	 * 
	 * @var array
	 */
	protected $_components;
	
	/**
	 * Indicates if the request is provided by a device with a location sensor (required)
	 * 
	 * @var boolean
	 */
	protected $_sensor;

	/**
	 * Google Maps Key
	 *
	 * @var string
	 */
	protected $_sKey;
	
	/**
	 * Bounding box to limit results within a given viewport (optional)
	 * 
	 * @var LatLngBounds
	 */
	protected $_bounds;
	
	/**
	 * Region code (ccTLD or ISO-3166-1 value) to limit results within a particular region (optional)
	 *
	 * @var string
	 */
	protected $_region;
	
	/**
	 * Specify the language in which to return results 
	 * 
	 * @var string
	 */
	protected $_language;

	/**
	 * Request constructor.
	 *
	 * @param string $sensor
	 */
	public function __construct($sensor = self::NO_SENSOR)
	{
		$this->_sensor = $sensor;
	}
	
	/**
	 * @return the $address
	 */
	public function getAddress() 
	{
		return $this->_address;
	}

	/**
	 * @param string $address
	 */
	public function setAddress($address) 
	{
		$this->_address = $address;
	}

	/**
	 * @return the $latLng
	 */
	public function getLatLng() 
	{
		return $this->_latLng;
	}

    /**
     * @param Parameters\LatLngParameter $latLng
     * @return Request
     */
    public function setLatLng(LatLngParameter $latLng)
	{
		$this->_latLng = $latLng;

        return $this;
	}

	/**
	 * @return the $bounds
	 */
	public function getBounds() 
	{
		return $this->_bounds;
	}

    /**
     * @param Parameters\LatLngBoundsParameter $bounds
     * @return Request
     */
    public function setBounds(LatLngBoundsParameter $bounds)
	{
		$this->_bounds = $bounds;

        return $this;
	}

	/**
	 * @return the $language
	 */
	public function getLanguage() 
	{
		return $this->_language;
	}

    /**
     * @param $language
     * @return Request
     */
    public function setLanguage($language)
	{
		$this->_language = $language;

        return $this;
	}

	/**
	 * @return the $region
	 */
	public function getRegion() 
	{
		return $this->_region;
	}

    /**
     * @param $region
     * @return Request
     */
    public function setRegion($region)
	{
		$this->_region = $region;

        return $this;
	}
	
	/**
	 * @return the $components
	 */
	public function getComponents() 
	{
		return $this->_components;
	}

    /**
     * @param Parameters\ComponentSetParameter $components
     * @return Request
     */
    public function setComponents(ComponentSetParameter $components)
	{
		$this->_components = $components;

        return $this;
	}

	/**
	 * @return the $sensor
	 */
	public function getSensor() 
	{
		return $this->_sensor;
	}

    /**
     * @param $sensor
     * @return Request
     */
    public function setSensor($sensor)
	{
		$this->_sensor = $sensor;

        return $this;
	}

	/**
	 * @return the $sensor
	 */
	public function getKey()
	{
		return $this->_sKey;
	}

	/**
	 * @param $sKey
	 * @return Request
	 */
	public function setKey($sKey)
	{
		$this->_sKey = $sKey;

		return $this;
	}
	
	/**
	 * Tranform request to URL parameters
	 *
	 * @return NULL|string
	 */
	public function getUrlParameters()
	{
		$requiredParameters = array('address', 'latlng', 'components', 'sensor');
		$optionalParameters = array('bounds', 'language', 'region', 'components', 'key');
	
		$url = '';
		foreach ($requiredParameters as $parameter) {
			$method = 'get' . $parameter;
			$requiredParam = $this->$method();
			if (!empty($requiredParam)) {
				if ($url !== '') {
					$url .= '&';
				}
				if (is_object($requiredParam)) {
					$requiredParam = $requiredParam->toString();
				}
				$url .= $parameter . '=' . urlencode($requiredParam);
			}
		}
		if ($url === '') {
			return null;
		}
	
		foreach ($optionalParameters as $option) {
			$method = 'get' . $option;
			$optionParam = $this->$method();
			if (!empty($optionParam)) {
				if (is_object($optionParam)) {
					$optionParam = $optionParam->toString();
				}
				$url .= '&' . $option . '=' . urlencode($optionParam);
			}
		}
		
		return $url;
	}
}
