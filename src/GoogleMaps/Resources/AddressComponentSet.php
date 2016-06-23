<?php

namespace MBtecZfGoogleMaps\Resources;

use MBtecZfGoogleMaps\GenericCollection;

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
