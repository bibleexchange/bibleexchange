<?php namespace BibleExchange\BeSync;

use BibleExchange\Entities\User;

class Synchronizer {
	
	$cacheMinutes;
	$api;
	
	public function __construct(User $user, $cacheMinutes = 120, array $api_classes){
		
		$this->cacheMinutes = $cacheMinutes;
		$this->api = $api_classes;
		
		$this->syncTheseApi();
	}
	
	public function syncTheseApi(){
		
		$syncThese = [];
		
		foreach($this->api AS $class){
			$syncThese[] = $class::isSynched();
		}
		
		return $syncThese
		
	}
	
	public function getNewContent($api_to_sync){
		
		$changes = [];
		
		foreach($api_to_sync AS $class){
			$changes[$class] = $class::getChanges();
		}
		
		return $changes;
	}
	
	public function translateNewContent($changes){
		
		$translatedContent = [];
		
		foreach($changes AS $key => $value){
			$translatedContent[] = $key::translateContent($value);
		}
		
		return $translatedContent;
		
	}
}