<?php

namespace MBtecZfGoogleMaps\Service;

use Zend\Hydrator\ArraySerializable;
use Zend\Json\Json;
use Zend\Http\Client as HttpClient;
use Zend\Uri\Uri;
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
    const XML_FORMAT = 'xml';
    const JSON_FORMAT = 'json';

    private $_sApiServerKey = '';

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
     * @param string $format
     */
    public function __construct($sApiServerKey, $format = 'json')
    {
        $this->_sApiServerKey = $sApiServerKey;

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
     * @return MBtecZfGoogleMaps\Request
     */
    public function getNewRequest()
    {
        $oRequest = new MBtecZfGoogleMaps\Request();

        return $oRequest;
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
     * @param Request $request
     *
     * @return Response
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function geocode(Request $request)
    {
        if (null === $request) {
            throw new MBtecZfGoogleMaps\Exception\InvalidArgumentException('request');
        }

        $uri = new Uri();
        $uri->setScheme(self::GOOGLE_MAPS_SCHEME);
        $uri->setHost(self::GOOGLE_MAPS_APIS_URL);
        $uri->setPath(self::GOOGLE_GEOCODING_API_PATH);

        $urlParameters = $request->getUrlParameters();
        if (null === $urlParameters) {
            throw new MBtecZfGoogleMaps\Exception\RuntimeException('Invalid URL parameters');
        }

        $urlParameters['key'] = $this->_sApiServerKey;

        $uri->setQuery($urlParameters);
        $client = $this->getHttpClient();
        $client->resetParameters();
        $client->setUri($uri);

        $stream = $client->send();

        $body = Json::decode($stream->getBody(), Json::TYPE_ARRAY);
        $hydrator = new ArraySerializable();

        $response = new MBtecZfGoogleMaps\Response();
        $response->setRawBody($body);
        if (!isset($body['status'])) {
            throw new MBtecZfGoogleMaps\Exception\RuntimeException('Invalid status');
        }
        $response->setStatus($body['status']);
        if (!isset($body['results'])) {
            throw new MBtecZfGoogleMaps\Exception\RuntimeException('Invalid results');
        }

        if (empty($body['results'])) {
            throw new MBtecZfGoogleMaps\Exception\NoResultsException('Empty resultset');
        }

        $resultSet = new MBtecZfGoogleMaps\ResultSet();
        foreach ($body['results'] as $data) {
            $result = new MBtecZfGoogleMaps\Result();
            $hydrator->hydrate($data, $result);
            $resultSet->addElement($result);
        }
        $response->setResults($resultSet);

        return $response;
    }
}
