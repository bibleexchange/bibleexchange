<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class BibleVersion extends Model {

	protected $table = 'bible_versions';
	
	public $timestamps = false;
	
	protected $fillable = ['name','short'];
	
}
