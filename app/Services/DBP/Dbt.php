<?php
/**
 * Class Dbt
 * 
 * DBT API Client SDK for DPT API V 2
 *
 * @copyright  Copyright (c) 2011-2014 Faith Comes by Hearing (http://faithcomesbyhearing.com)
 * @license This software is available under the MIT license. See http://opensource.org/licenses/MIT for more info.
 * 
 * Documentation for DBT API calls is located at http://www.digitalbibleplatform.com/docs/
 * 
 */

class Dbt
{
	// Configuration
	
	const REPLY = 'json';
	
	const API_URI = 'http://dbt.io';
	
	/**
	 * API Version
	 * @var string
	 */
	protected $_apiVersion = '2';
	
	/**
	 * URI to which to GET.
	 * @var string
	 */
	protected $_apiUri;
	
	/**
	 * Params which are shared on every API call.
	 * @var array
	 */
	protected $_dbtParams = array();
	
	/**
	 * Pointer to method that returns the response format constructed for the object
	 * made public so that a user can change response type after initialization (mostly for debugging)
	 * @var string
	 */
	protected $_response;
	
	/**
	 * Construct Dbt object
	 * 
	 * @param string $applicationKey The identity of the app in the form of an application key  
	 * @param string $apiUrl URL to use instead of default url
	 * @param string $reply reply protocol.
	 * @param string $responseType return type of function (json[default]| array[php array]|url[only returns api url])
	 * @param string $echo [true|false] whether or not to echo the call parameters
	 * @param string $callback function name to use for JSONP reply.
	 */
	public function __construct($applicationKey, $_apiUri = null, $reply = null, $responseType = null, $echo = null, $callback = null)
	{
		$this->_apiUri = ($_apiUri == null) ? self::API_URI : $_apiUri;
		
		$this->_dbtParams = array(
			'v' => $this->_apiVersion,
			'key' => $applicationKey,
			'reply' => (($reply == null) ? self::REPLY : $reply),
			'callback' => $callback,
			'echo' => $echo
		);
	
		if ($responseType == 'array') {
			$this->_response = 'getArrayResponse';
		} elseif ($responseType == 'url') {
			$this->_response = 'getApiUri';
		} else {
			$this->_response = 'getJSONResponse';
		}
	}
 
	/**
	 * Imports a JSON api response to a PHP array to be used by the server.
	 *
	 * @param $resourceGroup api resource group to call
	 * @param $resource api resource to call
	 * @param $params api resource group resource method params
	 * @return array|null return from API as PHP array or NULL
	 */
	protected function getArrayResponse($resourceGroup, $resource, $params)
	{
		$feed = $this->getJSONResponse($resourceGroup, $resource, $params);
		if ($feed != '') {
			return json_decode($feed, true);
		} else {
			return null;
		}
	}
	
	/**
	 * Queries dbt api and returns the response in JSON format.
	 *
	 * @param $resourceGroup api resource group to call
	 * @param $resource api resource to call
	 * @param $params api resource group resource method params
	 * @return string|JSON return from API or NULL
	 */
	protected function getJSONResponse($resourceGroup, $resource, $params)
	{
		$feed = null;
		$uri = $this->getApiUri($resourceGroup, $resource, $params);
		if ($uri != null) {
			@$feed = file_get_contents($uri);
		}
		return $feed;
	}
	
	/**
	 * Builds a specific api call URL depending on passed parameters.
	 * 
	 * @param $resourceGroup api resource group to call
	 * @param $resource api resource to call
	 * @param $params api resource group resource method params
	 */
	protected function getApiUri($resourceGroup, $resource, $params)
	{
		$requestParams = array_merge($this->_dbtParams, $params);
		
		$requestStrings = array();
		
		foreach ($requestParams as $name => $value) {
			if ($value !== null) {
				//if for some reason the value is an array, we need to take the first element
				while (is_array($value)) {
					$value=array_shift($value);
				}
				$requestStrings[] = $name."=".urlencode($value);   //updated to urlencode param values automatically
			}
		}

		return $this->_apiUri.'/'.$resourceGroup.'/'.$resource.'?'.implode("&", $requestStrings);
	}
	
	/**
	 * Wrapper method for /api/apiversion call
	 * 
	 */
	public function getApiVersion()
	{
		$params = array();
		
		return $this->{$this->_response}('api', 'apiversion', $params);
	}
	
	/**
	 * Wrapper method for /api/reply call
	 * 
	 */
	public function getApiReply()
	{
		$params = array();
		
		return $this->{$this->_response}('api', 'reply', $params);
	}

	/**
	 * Wrapper method for /audio/location call
	 * 
	 * @param string $protocol Allows the caller to restrict potential servers 
	 *      from being returned that don't support a specified protocol. 
	 *      Examples: http, https, rtmp, rtmp-amazon
	 */
	public function getAudioLocation($protocol = null)
	{
		$params = array('protocol' => $protocol);
		
		return $this->{$this->_response}('audio', 'location', $params);
	}
	
	/**
	 * Wrapper method for /audio/path call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param string $bookId book id of the book to get chapters for
	 * @param int $chapterId chapter id of the chapter to get audio for 
	 */
	public function getAudioPath($damId, $bookId = null, $chapterId = null)
	{
		$params = array(
			'dam_id' => $damId,
			'book_id' => $bookId,
			'chapter_id' => $chapterId,
		);
		
		return $this->{$this->_response}('audio', 'path', $params);
	}
	
	/**
	 * Wrapper method for /audio/zippath call
	 * 
	 * @param string $damId DAM ID of volume
	 */
	public function getAudioZippath($damId)
	{
		$params = array(
			'dam_id' => $damId
		);
		
		return $this->{$this->_response}('audio', 'zippath', $params);
	}
	
	/**
	 * Wrapper method for /audio/versestart call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param string $bookId book id of the book to get chapters for
	 * @param int $chapterId chapter id of the chapter to get audio for 
	 */
	public function getVerseStart($damId, $bookId, $chapterId)
	{
		$params = array(
			'dam_id' => $damId,
			'book_id' => $bookId,
			'chapter_id' => $chapterId,
		);
		
		return $this->{$this->_response}('audio', 'versestart', $params);
	}
	
	/**
	 * 
	 * Wrapper method for /library/language call
	 * 
	 * @param string $code language code on which to filter
	 * @param string $name language name in either native language or English on which to filter
	 * @param string $sortBy [code|name|english]
	 * @param string $fullWord [true|false] interpret $name as full words only
	 * @param string $familyOnly [true|false] return only language families
	 */
	public function getLibraryLanguage($code = null, $name = null, $sortBy = null, $fullWord = null, $familyOnly = null)
	{
		$params = array(
			'code' => $code,
			'name' => $name,
			'full_word' => $fullWord,
			'family_only' => $familyOnly,
			'sort_by' => $sortBy
		);
		
		return $this->{$this->_response}('library', 'language', $params);
	}
	
	/**
	 * 
	 * Wrapper method for /library/version call
	 * 
	 * @param string $code version code on which to filter
	 * @param string $name version name in either native language or English on which to filter
	 * @param string $sortBy [code|name|english]
	 */
	public function getLibraryVersion($code = null, $name = null, $sortBy = null)
	{
		$params = array(
			'code' => $code,
			'name' => $name,
			'sort_by' => $sortBy
		);
		
		return $this->{$this->_response}('library', 'version', $params);
	}
	
	/**
	 * Wrapper method for /library/volume call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param string $media [text|audio|video] the format of languages the caller 
	 *     is interested in.All are returned by default.
	 * @param string $delivery [streaming|download|mobile|any|none] a criteria 
	 *     for approved delivery method. 'any' means any of the supported 
	 *     methods (this list may change over time). 'none' means assets that 
	 *     are not approved for any of the supported methods. All returned by 
	 *     default.
	 * @param string $language Filter the versions returned to a specified 
	 *     language. For example return all the 'English' volumes.
	 * @param string $languageCode Filter the volumes returned to a specified 
	 *     language code. For example return all the 'eng' volumes.
	 * @param string $versionCode Filter the volumes returned to a specified 
	 *     version code. For example return all the 'ESV' volumes.
	 * @param timestamp $updated This is a unix timestamp in UTC to restrict 
	 *     volumes returned only if they were modified since the specified time.
	 * @param string $status publishing status of volume
	 * @param string $expired [true|false] whether or not the volume is expired
	 * @param integer @orgId Id of organization to which volume belongs
	 * @param string $fullWord [true|false] interpret $name as full words only
	 * @param string $languageFamilyCode Filter the volumes returned to a specified
	 * 			language code for language family
	 */
	public function getLibraryVolume(
		$damId = null,
		$fcbhId = null,
		$media = null,
		$delivery = null,
		$language = null,
		$languageCode = null,
		$versionCode = null,
		$updated = null,
		$status = null,
		$expired = null,
		$orgId = null,
		$fullWord = null,
		$languageFamilyCode = null
	) {
			
		$params = array('dam_id' => $damId,
			'fcbh_id' => $fcbhId,
			'media' => $media,
			'delivery' => $delivery,
			'language' => $language,
			'full_word' => $fullWord,
			'language_code' => $languageCode,
			'language_family_code' => $languageFamilyCode,
			'version_code' => $versionCode,
			'updated' => $updated,
			'status' => $status,
			'expired' => $expired,
			'organization_id' => $orgId
		);
		
		return $this->{$this->_response}('library', 'volume', $params);
	}
	
	/**
	 * Wrapper method for /library/volumelanguage call.
	 * 
	 * @param string $root the language name root. Can be used to restrict the 
	 *     response to only languages that start with 'Quechua' for example
	 * @param string $languageCode (optional) 3 letter language code
	 * @param string $media [text|audio|both] the format of languages the caller 
	 *     is interested in. This specifies if you want languages available in 
	 *     text or languages available in audio or only languages available in 
	 *     both. All are returned by default.
	 * @param string $delivery [streaming|download|mobile|any|none] a criteria 
	 *     for approved delivery method. 'any' means any of the supported 
	 *     methods (this list may change over time). 'none' means assets that 
	 *     are not approved for any of the supported methods. All returned by 
	 *     default.
	 * @param string $status
	 * @param integer $orgId
	 * @param string $fullWord [true|false] interpret $name as full words only
	 */
	public function getLibraryVolumeLanguage(
		$root = null,
		$languageCode = null,
		$media = null,
		$delivery = null,
		$status = null,
		$orgId = null,
		$fullWord = null
	) {
		$params = array(
			'root' =>  $root,
			'full_word' => $fullWord,
			'language_code' => $languageCode,
			'media'  => $media,
			'delivery' => $delivery,
			'status' => $status,
			'organization_id' => $orgId
		);
		
		return $this->{$this->_response}('library', 'volumelanguage', $params);
	}
	
	/**
	 * Wrapper method for /library/volumelanguagefamily call.
	 * 
	 * @param string $root the language name root. Can be used to restrict the 
	 *     response to only languages that start with 'Quechua' for example
	 * @param string $languageCode (optional) 3 letter language code
	 * @param string $media [text|audio|both] the format of languages the caller 
	 *     is interested in. This specifies if you want languages available in 
	 *     text or languages available in audio or only languages available in 
	 *     both. All are returned by default.
	 * @param string $delivery [streaming|download|mobile|any|none] a criteria 
	 *     for approved delivery method. 'any' means any of the supported 
	 *     methods (this list may change over time). 'none' means assets that 
	 *     are not approved for any of the supported methods. All returned by 
	 *     default.
	 * @param string $status
	 * @param integer $orgId
	 * @param string $fullWord [true|false] interpret $name as full words only
	 */
	public function getLibraryVolumeLanguageFamily(
		$root = null,
		$languageCode = null,
		$media = null,
		$delivery = null,
		$status = null,
		$orgId = null,
		$fullWord = null
	) {
		$params = array(
			'root' =>  $root,
			'full_word' => $fullWord,
			'language_code' => $languageCode,
			'media'  => $media,
			'delivery' => $delivery,
			'status' => $status,
			'organization_id' => $orgId
		);
		
		return $this->{$this->_response}('library', 'volumelanguagefamily', $params);
	}
	
	/**
	 * Wrapper method for /library/bookorder call
	 * 
	 * @param string $damId DAM ID of volume
	 */
	public function getLibraryBookOrder($damId)
	{
		$params = array(
			'dam_id' => $damId
		);
				
		return $this->{$this->_response}('library', 'bookorder', $params);
	}
	
	/**
	 * Wrapper method for /library/book call
	 * 
	 * @param string $damId DAM ID of volume
	 */
	public function getLibraryBook($damId)
	{
		$params = array(
			'dam_id' => $damId
		);
				
		return $this->{$this->_response}('library', 'book', $params);
	}
	
	/**
	 * Wrapper method for /library/bookname call
	 * 
	 * @param string $languageCode language code for book names
	 */
	public function getLibraryBookName($languageCode)
	{
		$params = array(
			'language_code' => $languageCode
		);
				
		return $this->{$this->_response}('library', 'bookname', $params);
	}
	
	/**
	 * Wrapper method for /library/chapter call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param string $bookId book id of the book to get chapters for
	 */
	public function getLibraryChapter($damId, $bookId = null)
	{
		$params = array(
			'dam_id' => $damId,
			'book_id' => $bookId
		);
				
		return $this->{$this->_response}('library', 'chapter', $params);
	}
	
  /**
	 * Wrapper method for /library/verseinfo call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param string $bookId book id of the book to get text for
	 * @param int $chapterId chapter id of the chapter to get text for 
	 * @param int $verse_start verse id of the verse to get text for (start position)
	 * @param int $verse_end verse id of the verse to get text for (end position) 
	 */
	public function getLibraryVerseinfo(
		$damId,
		$bookId = null,
		$chapterId = null,
		$verseStart = null,
		$verseEnd = null
	) {
		$params = array(
			'dam_id'=> $damId,
			'book_id' => $bookId,
			'chapter_id' => $chapterId,
			'verse_start' => $verseStart,
			'verse_end' => $verseEnd
				);
		
		return $this->{$this->_response}('library', 'verseinfo', $params);
	}
	
	/**
	 * Wrapper method for /library/numbers call
	 * 
	 * @param string $languageCode language code for book names
	 * @param int $start first number for series of consecutive numbers returned
	 * @param int $end last number for series of consecutive numbers returned
	 */
	public function getLibraryNumbers($languageCode, $start, $end)
	{
		$params = array(
			'language_code' => $languageCode,
			'start' => $start,
			'end' => $end
		);
				
		return $this->{$this->_response}('library', 'numbers', $params);
	}
	
	/**
	 * Wrapper method for /library/metadata call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param int $organizationId ID for organization by which to filter
	 */
	public function getLibraryMeta($damId = null, $organizationId = null)
	{
		$params = array(
			'dam_id' => $damId,
			'organization_id' => $organizationId
		);
		return $this->{$this->_response}('library', 'metadata', $params);
	}
	
  /**
   * Wrapper method for /library/asset call
   * 
   * @param string $damId DAM ID of volume
   */
	public function getLibraryAsset($damId = null)
	{
		$params = array(
			'dam_id' => $damId
		);
			
		return $this->{$this->_response}('library', 'asset', $params);
	}
	
  /**
   * Wrapper method for /library/organization call
   * 
   * @param string $organizationName name of organization
   * @param int $organizationId ID for organization by which to filter
   */
	public function getLibraryOrganization($organizationName = null, $organizationId = null)
	{
		$params = array(
			'name' => $organizationName,
			'id' => $organizationId
		);
			
		return $this->{$this->_response}('library', 'organization', $params);
	}
	
	/**
	 * Wrapper method for /text/verse call
	 * 
	 * @param string $damId DAM ID of volume (null to use default from the 
	 *     class init)
	 * @param string $bookId book id of the book to get text for
	 * @param int $chapterId chapter id of the chapter to get text for 
	 * @param int $verse_start verse id of the verse to get text for (start position)
	 * @param int $verse_end verse id of the verse to get text for (end position) 
	 * @param string $markup If specified returns the verse text in a variety of
	 *      standarized formats. By default the internal DBT format is returned. 
	 *      Current options include OSIS, and native (the default DBT format).
	 */
	public function getTextVerse(
		$damId,
		$bookId = null,
		$chapterId = null,
		$verseStart = null,
		$verseEnd = null,
		$markup = null
	) {
		$params = array(
			'dam_id'=> $damId,
			'book_id' => $bookId,
			'chapter_id' => $chapterId,
			'verse_start' => $verseStart,
			'verse_end' => $verseEnd,
			'markup' => $markup
				);
		return $this->{$this->_response}('text', 'verse', $params);
	}
	
	/**
	 * Wrapper method for /text/search call
	 * 
	 * @param string $damId DAM ID of volume
	 * @param string $query The text that the caller wishes to search for in the
	 *      specified text.
	 * @param string $bookId The book id to limit the search to.
	 * @param int $offset The offset for the set of results to return to start from.
	 * @param int $limit The number of results to return. Default is 50.
	 */
	public function getTextSearch($damId, $query, $bookId = null, $offset = null, $limit = null)
	{
		$params = array(
			'dam_id' => $damId,
			'query' => $query,
			'book_id' => $bookId,
			'offset' => $offset,
			'limit' => $limit
		);
		
		return $this->{$this->_response}('text', 'search', $params);
	}
	
	/**
	 * Wrapper method for /text/searchgroup call
	 * 
	 * @param string $damId DAM ID of volume (null to use default from the 
	 *     class init)
	 * @param string $query The text that the caller wishes to search for in the
	 *      specified text.
	 */
	public function getTextSearchgroup($damId, $query)
	{
		$params = array(
			'dam_id' => $damId,
			'query' => $query
		);
		
		return $this->{$this->_response}('text', 'searchgroup', $params);
	}
	
	/**
	 * Wrapper method for /video/jesusfilm call
	 * 
	 * @param string $damId DAM ID of volume (null to use default from the 
	 *     class init)
	 * @param string $bookId book id of the book to get text for
	 * @param int $chapterId chapter id of the chapter to get text for 
	 * @param int $verse_start verse id of the verse to get text for (start position)
	 * @param int $verse_end verse id of the verse to get text for (end position) 
	 * @param string $markup If specified returns the verse text in a variety of
	 *      standarized formats. By default the internal DBT format is returned. 
	 *      Current options include OSIS, and native (the default DBT format).
	 */
	public function getVideoJesusfilm($damId, $encoding, $bookId = null, $chapterId = null, $verseId = null)
	{
		$params = array(
			'dam_id'=> $damId,
			'encoding' => $encoding,
			'book_id' => $bookId,
			'chapter_id' => $chapterId,
			'verse_id' => $verseId
		);
		
		return $this->{$this->_response}('video', 'jesusfilm', $params);
	}
	
	/**
	 * Wrapper method for /video/videopath call
	 * 
	 * @param string $damId DAM ID of volume (null to use default from the 
	 *     class init)
	 * @param string $encoding The encoding to request. Either mp4 or m3u8.
	 * @param string $resolution The video resolution: lo, med, or hi
	 * @param int $segmentOrder The segment order to retrieve
	 * @param string $bookId book id of the book to get text for
	 * @param int $chapterId chapter id of the chapter to get text for 
	 * @param int $verseId Verse id to request
	 */
	public function getVideoPath($damId, $encoding = 'mp4', $resolution = 'lo', $segmentOrder = null, $bookId = null, $chapterId = null, $verseId = null)
	{
		$params = array(
			'dam_id'=> $damId,
			'encoding' => $encoding,
			'resolution' => $resolution,
			'segment_order' => $segmentOrder,
			'book_id' => $bookId,
			'chapter_id' => $chapterId,
			'verse_id' => $verseId
		);
		
		return $this->{$this->_response}('video', 'videopath', $params);
	}
}
