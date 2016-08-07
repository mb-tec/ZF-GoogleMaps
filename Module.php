<?php

namespace MBtecZfGoogleMaps;

use Zend\View\HelperPluginManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * Class        Module
 * @package     MBtecZfGoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Module implements AutoloaderProviderInterface, ViewHelperProviderInterface
{
    /**
     * Return MBtecZfGoogleMaps autoload config.
     *
     * @see AutoloaderProviderInterface::getAutoloaderConfig()
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'googleMapsJs' => function(HelperPluginManager $oPm) {
                    $sApiKey = $oPm->getServiceLocator()->get('config')['mbtec']['zf-google_maps']['api_key'];

                    return new View\Helper\GoogleMapsJs($sApiKey);
                },
            ],
        ];
    }
}
