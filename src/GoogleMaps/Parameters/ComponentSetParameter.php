<?php

namespace MBtec\GoogleMaps\Parameters;

use MBtec\GoogleMaps\GenericCollection;

/**
 * Class        ComponentSetParameter
 * @package     MBtec\GoogleMaps\Parameters
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class ComponentSetParameter extends GenericCollection implements ParameterInterface
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('MBtec\\GoogleMaps\\Parameters\\ComponentParameter');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \GoogleMaps\Parameters\ParameterInterface::toString()
	 */
	public function toString() 
	{
		$components = null;
		foreach ($this->collection as $element) {
			$components .= $element->toString();
		}

		return $components;
	}
}
