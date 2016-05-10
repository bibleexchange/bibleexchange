<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Role extends Model {

	use PresentableTrait;

	protected $fillable = ['name'];

}
