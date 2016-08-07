<?php

namespace MBtecZfGoogleMaps\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class        EmailObfuscator
 * @package     MBtecZfEmailObfuscator\View\Helper
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class GoogleMapsJs extends AbstractHelper
{
    const API_URL = 'https://maps.googleapis.com/maps/api/js';

    /**
     * GoogleMapsJs constructor.
     *
     * @param $aApiKey
     */
    public function __construct($aApiKey)
    {
        $this->_sApiKey = $aApiKey;
    }

    /**
     * @param array $aLibs
     */
    public function __invoke(array $aLibs = [])
    {
        $sFile = self:: API_URL . '?key=' . $this->_sApiKey;

        if (!empty($aLibs)) {
            $sFile .= '&libraries=' . implode(',', $aLibs);
        }

        $this->getView()->inlineScript()->appendFile($sFile);
    }
}