Kohana Curl Library
===========
Very basic curl wrapper class to make using curl in your project a little less painfull

How to use
----------
Simply copy the file into your application (or copy and paste the class into your /classes directory for newer kohana versions)

**GET Request**

	Curl::get(String url, Array headers, Bool only_headers, Array curl_options);

**POST Request**

	Curl::post(String url, Array data, Array headers, Bool only_headers, Array curl_options);

Known Issues
------------
No known issues at this time!

Any feedback greatly appreciated!