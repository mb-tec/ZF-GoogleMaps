<?php

namespace MBtecZfGoogleMaps;

use Zend\View\HelperPluginManager;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class        Module
 * @package     MBtecZfGoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Module implements ViewHelperProviderInterface, ServiceProviderInterface
{
    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'googleMapsJs' => function($oSm) {
                    $sApiKey = (string)$oSm->get('config')['mbtec']['zf-google_maps']['api']['browser_key'];

                    return new View\Helper\GoogleMapsJs($sApiKey);
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'mbtec.zf-google_maps.service' => function($oSm) {
                    $sApiKey = (string)$oSm->get('config')['mbtec']['zf-google_maps']['api']['server_key'];

                    return new Service\GeoCoder($sApiKey);
                },
            ],
        ];
    }
}
