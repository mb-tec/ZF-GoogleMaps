<?php

namespace MBtecZfGoogleMaps;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Class        Module
 * @package     MBtecZfGoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Module implements AutoloaderProviderInterface
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
}
