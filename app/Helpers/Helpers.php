<?php namespace BibleExchange\Helpers;

use BibleExchange\Entities\BibleVerse;
use Str;

class Helpers {

	public static function user_photos_path($unique_key)
	{
		return app_path() . '/assets/images/profiles/' . $unique_key .'/';
	}
	
	public static function pluralize($string, $number){
	
		if($number >= 2){
			
			$last_letter = strtolower($string[strlen($string)-1]);
			switch($last_letter) {
				case 'y':
					return substr($string,0,-1).'ies';
				case 's':
					return $string.'es';
				case 'o':
					return $string.'es';
				case 'x':
					return $string.'es';
				case 'f':
					return substr($string,0,-1).'ves';
				default:
					return $string.'s';
			}
			
		}else{
			return $string;
		}
	
	}
	
	public static function userTitleToUrl($string){
		
		$string = trim(preg_replace("/\s+/",' ',$string));
		
		return strtolower(str_replace(['-',' ',':','/-','/-','-/'],['_','-','/','/','/','/'], $string));
	}
	
	public static function dbTitleToHumanReadable($string){
		return ucwords(str_replace(['_','-','/','%20'],['-',' ',': ',' '],$string));
	
	}
	
	public static function convertReferences($text){
		
		$pattern = "/{%([^%]*)%}/";
		
		$newText = preg_replace_callback($pattern, function($m)
		{
			return BibleVerse::convertReferenceToQuote($m[1]);
		}, 
		$text);

		return $newText;
	
	}
	
	public static function arrayToCommaString($objectOfTags){
		
		if(count($objectOfTags) < 1){
			return null;
		}
		return implode(',',$objectOfTags->lists('name'));
	}
	
}