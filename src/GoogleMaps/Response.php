<?php

namespace MBtec\GoogleMaps;

/**
 * Class        Response
 * @package     MBtec\GoogleMaps
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class Response 
{
	const ERROR 			= 'ERROR';
	const INVALID_REQUEST 	= 'INVALID_REQUEST';
	const OK 				= 'OK';
	const OVER_QUERY_LIMIT 	= 'OVER_QUERY_LIMIT';
	const REQUEST_DENIED 	= 'REQUEST_DENIED';
	const UNKNOWN_ERROR 	= 'UNKNOWN_ERROR';
	const ZERO_RESULTS 		= 'ZERO_RESULTS';

	/**
	 * @var
	 */
	protected $status;

	/**
	 * @var
	 */
	protected $results;

	/**
	 * @var
	 */
	protected $rawBody;
	
	/**
	 * @return the $status
	 */
	public function getStatus() 
	{
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus($status) 
	{
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getResults() 
	{
		return $this->results;
	}

	/**
	 * @param ResultSet $results
	 */
	public function setResults(ResultSet $results) 
	{
		$this->results = $results;
	}

	/**
	 * @return string
	 */
	public function getRawBody() 
	{
		return $this->rawBody;
	}

	/**
	 * @param $rawBody
	 */
	public function setRawBody($rawBody) 
	{
		$this->rawBody = $rawBody;
	}

}
