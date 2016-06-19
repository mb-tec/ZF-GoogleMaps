<?php

namespace MBtec\GoogleMaps\Resources;

use MBtec\GoogleMaps\GenericCollection;

class AddressComponentSet extends GenericCollection
{
	/**
	 * Constructor
	 */
	public function __construct() 
	{
		parent::__construct('MBtec\\GoogleMaps\\Resources\\AddressComponent');
	}
}
