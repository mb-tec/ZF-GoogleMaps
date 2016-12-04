<?php

namespace MBtecZfGoogleMaps\Service;

use Zend\Hydrator\ArraySerializable;
use Zend\Json\Json;
use Zend\Http\Client as HttpClient;
use Zend\Uri\Http as HttpUri;
use MBtecZfGoogleMaps;

/**
 * Class        GeoCoder
 * @package     MBtecZfGoogleMaps\Service
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class GeoCoder
{
    const GOOGLE_MAPS_SCHEME = 'https';
    const GOOGLE_MAPS_APIS_URL = 'maps.googleapis.com';
    const GOOGLE_GEOCODING_API_PATH = '/maps/api/geocode/json';
    const DEFAULT_LANG = 'en';
    const XML_FORMAT = 'xml';
    const JSON_FORMAT = 'json';

    private $_sApiServerKey = '';
    private $_sDefaultLanguage = '';

    /**
     * Response format (XML or JSON)
     * @var string
     */
    protected $format;

    /**
     * Http client
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * GeoCoder constructor.
     *
     * @param        $sApiServerKey
     * @param        $sDefaultLanguage
     * @param string $format
     */
    public function __construct($sApiServerKey, $sDefaultLanguage, $format = 'json')
    {
        $this->_sApiServerKey = $sApiServerKey;
        $this->_sDefaultLanguage = $sDefaultLanguage;

        $validFormats = [
            self::JSON_FORMAT,
            self::XML_FORMAT,
        ];

        if (!in_array($format, $validFormats)) {
            throw new MBtecZfGoogleMaps\Exception\InvalidArgumentException('format');
        }

        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Get the HttpClient instance
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (empty($this->httpClient)) {
            $this->httpClient = new HttpClient();
        }
        return $this->httpClient;
    }

    /**
     * @param MBtecZfGoogleMaps\Request $request
     *
     * @return MBtecZfGoogleMaps\Response
     */
    protected function _geocode(MBtecZfGoogleMaps\Request $request)
    {
        if (null === $request) {
            throw new MBtecZfGoogleMaps\Exception\InvalidArgumentException('request');
        }

        $aUrlParameters = $request->getUrlParameters();
        if (empty($aUrlParameters)) {
            throw new MBtecZfGoogleMaps\Exception\RuntimeException('Invalid URL parameters');
        }

        $aUrlParameters['key'] = $this->_sApiServerKey;

        $uri = new HttpUri();
        $uri
            ->setScheme(self::GOOGLE_MAPS_SCHEME)
            ->setHost(self::GOOGLE_MAPS_APIS_URL)
            ->setPath(self::GOOGLE_GEOCODING_API_PATH)
            ->setQuery($aUrlParameters);

        $client = $this
            ->getHttpClient()
            ->resetParameters()
            ->setUri($uri);

        $stream = $client->send();

        $body = Json::decode($stream->getBody(), Json::TYPE_ARRAY);

        if (!isset($body['status'])) {
            throw new MBtecZfGoogleMaps\Exception\RuntimeException('Invalid status');
        }

        if (!isset($body['results'])) {
            throw new MBtecZfGoogleMaps\Exception\RuntimeException('Invalid results');
        }

        if (empty($body['results'])) {
            throw new MBtecZfGoogleMaps\Exception\NoResultsException('Empty resultset');
        }

        $hydrator = new ArraySerializable();

        $resultSet = new MBtecZfGoogleMaps\ResultSet();

        foreach ($body['results'] as $data) {
            $result = new MBtecZfGoogleMaps\Result();
            $hydrator->hydrate($data, $result);
            $resultSet->addElement($result);
        }

        $response = new MBtecZfGoogleMaps\Response();
        $response
            ->setRawBody($body)
            ->setStatus($body['status'])
            ->setResults($resultSet);

        return $response;
    }

    /**
     * @param      $sAddress
     * @param null $sLang
     *
     * @return MBtecZfGoogleMaps\Response
     */
    public function geoCodeAddress($sAddress, $sLang = null)
    {
        $oRequest = new MBtecZfGoogleMaps\Request();
        $oRequest
            ->setAddress($sAddress)
            ->setLanguage($sLang ?: $this->_sDefaultLanguage);

        return $this->_geocode($oRequest);
    }

    /**
     * @param $fLat
     * @param $fLng
     *
     * @return mixed
     */
    public function geoCodeLatLng($fLat, $fLng)
    {
        $oLatLng = new MBtecZfGoogleMaps\Resources\LatLng(['lat' => $fLat, 'lng' => $fLng]);
        $oLatLngParam = new MBtecZfGoogleMaps\Parameters\LatLngParameter($oLatLng);

        $oRequest = new MBtecZfGoogleMaps\Request();
        $oRequest->setLatLng($oLatLngParam);

        return $this->_geocode($oRequest);
    }
}
