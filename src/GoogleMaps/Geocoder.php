<?php

namespace MBtec\GoogleMaps;

use Zend\Hydrator\ArraySerializable;
use Zend\Json\Json;
use Zend\Http\Client as HttpClient;
use Zend\Uri\Uri;
use MBtec\GoogleMaps\Exception;

/**
 * Class        Geocoder
 * @package     MBtec\GoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class Geocoder
{
    const GOOGLE_MAPS_SCHEME = 'https';
    const GOOGLE_MAPS_APIS_URL = 'maps.googleapis.com';
    const GOOGLE_GEOCODING_API_PATH = '/maps/api/geocode/json';
    const XML_FORMAT = 'xml';
    const JSON_FORMAT = 'json';

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
     * @param string $format
     */
    public function __construct($format = 'json')
    {
        $validFormats = array(
            self::JSON_FORMAT,
            self::XML_FORMAT,
        );
        if (!in_array($format, $validFormats)) {
            throw new Exception\InvalidArgumentException('format');
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
     * @param Request $request
     *
     * @return Response
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function geocode(Request $request)
    {
        if (null === $request) {
            throw new Exception\InvalidArgumentException('request');
        }

        $uri = new Uri();
        $uri->setScheme(self::GOOGLE_MAPS_SCHEME);
        $uri->setHost(self::GOOGLE_MAPS_APIS_URL);
        $uri->setPath(self::GOOGLE_GEOCODING_API_PATH);

        $urlParameters = $request->getUrlParameters();
        if (null === $urlParameters) {
            throw new Exception\RuntimeException('Invalid URL parameters');
        }

        $uri->setQuery($urlParameters);
        $client = $this->getHttpClient();
        $client->resetParameters();
        $client->setUri($uri->toString());
        $stream = $client->send();

        $body = Json::decode($stream->getBody(), Json::TYPE_ARRAY);
        $hydrator = new ArraySerializable();

        $response = new Response();
        $response->setRawBody($body);
        if (!isset($body['status'])) {
            throw new Exception\RuntimeException('Invalid status');
        }
        $response->setStatus($body['status']);
        if (!isset($body['results'])) {
            throw new Exception\RuntimeException('Invalid results');
        }

        if (empty($body['results'])) {
            throw new Exception\NoResultsException('Empty resultset');
        }

        $resultSet = new ResultSet();
        foreach ($body['results'] as $data) {
            $result = new Result();
            $hydrator->hydrate($data, $result);
            $resultSet->addElement($result);
        }
        $response->setResults($resultSet);

        return $response;
    }
}
