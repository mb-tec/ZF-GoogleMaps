<?php

namespace MBtec\GoogleMaps;

/**
 * Class        ResultSet
 * @package     MBtec\GoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class ResultSet extends GenericCollection
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('MBtec\\GoogleMaps\\Result');
	}
}
