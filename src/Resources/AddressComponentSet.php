<?php

namespace MBtecZfGoogleMaps\Resources;

use MBtecZfGoogleMaps\GenericCollection;

/**
 * Class        AddressComponentSet
 * @package     MBtecZfGoogleMaps\Resources
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class AddressComponentSet extends GenericCollection
{
	/**
	 * Constructor
	 */
	public function __construct() 
	{
		parent::__construct(AddressComponent::class);
	}
}
