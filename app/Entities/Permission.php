<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Permission extends Model {

	use PresentableTrait;

    protected $fillable = ['name','display_name'];
	
}
