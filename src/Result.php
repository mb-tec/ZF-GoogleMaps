<?php

namespace MBtecZfGoogleMaps;

use Zend\Stdlib\ArraySerializableInterface;
use MBtecZfGoogleMaps\Exception\InvalidArgumentException;

/**
 * Class        Result
 * @package     MBtecZfGoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Result implements ArraySerializableInterface
{
    /**
     *
     * @var AddressComponentSet
     */
    protected $addressComponents;

    /**
     *
     * @var string
     */
    protected $formattedAddress = '';

    /**
     *
     * @var Geometry
     */
    protected $geometry;

    /**
     *
     * @var array
     */
    protected $types = [];

    /**
     *
     * @var boolean
     */
    protected $partialMatch;

    public function __construct($data = [])
    {
        $this->exchangeArray($data);
    }

    /**
     * @return AddressComponentSet
     */
    public function getAddressComponents()
    {
        return $this->addressComponents;
    }

    /**
     * @return string
     */
    public function getFormattedAddress()
    {
        return $this->formattedAddress;
    }

    /**
     * @return Geometry
     */
    public function getGeometry()
    {
        return $this->geometry;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return bool
     */
    public function getPartialMatch()
    {
        return $this->partialMatch;
    }

    /**
     * @param Resources\AddressComponent $addressComponent
     */
    public function addAddressComponent(Resources\AddressComponent $addressComponent)
    {
        if (null === $addressComponent) {
            throw new InvalidArgumentException('addressComponent');
        }
        if (null === $this->addressComponents) {
            $this->addressComponents = new Resources\AddressComponentSet();
        }
        $this->addressComponents->addElement($addressComponent);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Stdlib\ArraySerializableInterface::exchange[]
     */
    public function exchangeArray(array $data)
    {
        if (isset($data['address_components']) && is_array($data['address_components'])) {
            foreach ($data['address_components'] as $address) {
                if (is_array($address)) {
                    $this->addAddressComponent(new Resources\AddressComponent($address));
                }
            }
        }
        if (isset($data['types']) && is_array($data['types'])) {
            $this->types = $data['types'];
        }
        if (isset($data['formatted_address']) && is_string($data['formatted_address'])) {
            $this->formattedAddress = $data['formatted_address'];
        }
        if (isset($data['geometry']) && is_array($data['geometry'])) {
            $this->geometry = new Resources\Geometry($data['geometry']);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Stdlib\ArraySerializableInterface::getArrayCopy()
     */
    public function getArrayCopy()
    {
        $addressComponents = [];
        foreach ($this->getAddressComponents() as $addressComponent) {
            $addressComponents[] = $addressComponent->getArrayCopy();
        }
        // Partial match ?
        return [
            'address_components' => $addressComponents,
            'formatted_address' => $this->getFormattedAddress(),
            'geometry' => $this->getGeometry()->getArrayCopy(),
            'types' => $this->getTypes(),
        ];
    }
}
