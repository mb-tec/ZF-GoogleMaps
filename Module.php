<?php

namespace MBtecZfGoogleMaps;

use Zend\ServiceManager\ServiceManager;
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
                'googleMapsJs' => function(ServiceManager $oSm) {
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
                'mbtec.zf-google_maps.geocoder.service' => function(ServiceManager $oSm) {
                    $aConfig = $oSm->get('config')['mbtec']['zf-google_maps']['api'];
                    $sApiKey = (string)$aConfig['server_key'];
                    $sDefaultLang = !empty($aConfig['default_lang'])
                        ? $aConfig['default_lang']
                        : Service\GeoCoder::DEFAULT_LANG;

                    return new Service\GeoCoder($sApiKey, $sDefaultLang);
                },
            ],
        ];
    }
}
