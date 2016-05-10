<?php namespace BibleExchange\Entities;

class Email extends \Eloquent {
	protected $fillable = ['from','body','updated_at','created_at'];
}