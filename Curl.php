<?php

/**
 * undocumented class
 *
 * @package default
 * @author Matt Wells (www.ninjapenguin.co.uk)
 **/
class Curl_Core {
	
	private $resource = null;
	
	private $config = array();
	
	/**
	 * Factory Method
	 */
	public static function factory($data = array())
	{
		return new Curl($data);
	}
	
	/**
	 * Constructor
	 */
	public function __construct($data = array())
	{
		$config = array(
			CURLOPT_HEADER => false
		);
		
		//Apply any passed configuration
		$data += $config;
		$this->config = $data;
		
		$this->resource = curl_init();
				
		//Apply configuration settings
		foreach ($this->config as $key => $value) {
			$this->set_opt($key, $value);
		}
		
	}
	
	
	/**
	 * Set option
	 * @param String 	Curl option to set
	 * @param String	Value for option
	 * @chainable
	 */
	public function set_opt($key, $value)
	{
		curl_setopt($this->resource, $key, $value);
		return $this;
	}
	
	
	/**
	 * Execute the curl request and return the response
	 * @return String				Returned output from the requested resource
	 * @throws Kohana_User_Exception
	 */
	public function exec()
	{
		$ret = curl_exec($this->resource);
		
		//Wrap the error reporting in an exception
		if($ret === false) 
			throw new Kohana_User_Exception("Curl Error", curl_error($this->resource));
		else
			return $ret;
		
	}
	
	/**
	 * Get Error
	 * Returns any current error for the curl request
	 * @return string	The error
	 */
	public function get_error()
	{
		return curl_error($this->resource);
	}
	
	/**
	 * Destructor
	 */
	function __destruct()
	{
		curl_close($this->resource);
	}
	
	
	/**
	 * Get
	 * Execute an HTTP GET request using curl
	 * @param String	url to request
	 * @param Array		additional headers to send in the request
	 * @param Bool		flag to return only the headers
	 * @param Array		Additional curl options to instantiate curl with
	 */
	public static function get($url, Array $headers = array(), $headers_only = false, Array $curl_options = array())
	{
		$ch = Curl::factory($curl_options);
		
		$ch->set_opt(CURLOPT_URL, $url)
      	->set_opt(CURLOPT_RETURNTRANSFER, true)
		->set_opt(CURLOPT_NOBODY, $headers_only);
		
		//Set any additional headers
		if(!empty($headers)) $ch->set_opt(CURLOPT_HTTPHEADER, $headers);
		
		return $ch->exec();
	}
	
	
	/**
	 * Post
	 * Execute an HTTP POST request, posting the past parameters
	 * @param String	url to request
	 * @param Array		past data to post to $url
	 * @param Array		additional headers to send in the request
	 * @param Bool		flag to return only the headers
	 * @param Array		Additional curl options to instantiate curl with
	 */
	public static function post($url, Array $data = array(), Array $headers = array(), $headers_only = false, Array $curl_options = array())
	{
		$ch = Curl::factory($curl_options);
		
		$ch->set_opt(CURLOPT_URL, $url)
		->set_opt(CURLOPT_NOBODY, $headers_only)
		->set_opt(CURLOPT_RETURNTRANSFER, true)
		->set_opt(CURLOPT_POST, true)
		->set_opt(CURLOPT_POSTFIELDS, $data);
      
      	//Set any additional headers
		if(!empty($headers)) $ch->set_opt(CURLOPT_HTTPHEADER, $headers);
		
	    return $ch->exec();
	}
}

?>
