<?php

namespace MBtecZfGoogleMaps;

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
	/**
	 * Address to perform geocoding (required)
	 * 
	 * @var string
	 */
	protected $_address;

    /**
     * @var
     */
	protected $_latLng;
	
	/**
	 * Components filter to perform geocoding (optional if an address is provided else required)
	 * 
	 * @var array
	 */
	protected $_components;
	
    /**
     * @var
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
     * @return string
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
     * @return mixed
     */
	public function getLatLng() 
	{
		return $this->_latLng;
	}

    /**
     * @param Parameters\LatLngParameter $latLng
     *
     * @return $this
     */
    public function setLatLng(Parameters\LatLngParameter $latLng)
	{
		$this->_latLng = $latLng;

        return $this;
	}

    /**
     * @return LatLngBounds
     */
	public function getBounds() 
	{
		return $this->_bounds;
	}

    /**
     * @param Parameters\LatLngBoundsParameter $bounds
     *
     * @return $this
     */
    public function setBounds(Parameters\LatLngBoundsParameter $bounds)
	{
		$this->_bounds = $bounds;

        return $this;
	}

    /**
     * @return string
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
     * @return string
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
     * @return array
     */
	public function getComponents() 
	{
		return $this->_components;
	}

    /**
     * @param Parameters\ComponentSetParameter $components
     *
     * @return $this
     */
    public function setComponents(Parameters\ComponentSetParameter $components)
	{
		$this->_components = $components;

        return $this;
	}

	/**
	 * Tranform request to URL parameters
	 *
	 * @return NULL|string
	 */
	public function getUrlParameters()
	{
		$requiredParameters = ['address', 'latlng', 'components'];
		$optionalParameters = ['bounds', 'language', 'region', 'components'];
	
		$aParams = [];
		foreach ($requiredParameters as $parameter) {
			$method = 'get' . $parameter;
			$requiredParam = $this->$method();
			if ($requiredParam !== null) {
				if (is_object($requiredParam)) {
					$requiredParam = $requiredParam->toString();
				}

                $aParams[$parameter] = $requiredParam;
			}
		}

		foreach ($optionalParameters as $option) {
			$method = 'get' . $option;
			$optionParam = $this->$method();
			if ($optionParam !== null) {
				if (is_object($optionParam)) {
					$optionParam = $optionParam->toString();
				}

                $aParams[$option] = $optionParam;
			}
		}
		
		return $aParams;
	}
}
