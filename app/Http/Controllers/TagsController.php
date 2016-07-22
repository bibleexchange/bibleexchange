<?php namespace BibleExperience\Http\Controllers;

use BibleExperience\Tag;

use BibleExperience\Http\Requests;
use BibleExperience\Http\Controllers\Controller;

use Illuminate\Http\Request;
use BibleExperience\Helpers\Helpers as Helper;
use Flash, Input, Redirect;

class TagsController extends Controller {

	public function update()
	{
		$tagsArray = explode(',',Input::get('tags'));
		$tags = Tag::lists('name');
		
		$object_class_name = Input::get('object_class');
		$object = $object_class_name::find(Input::get('object_id'));
		$object->tags()->detach();
		
		foreach($tagsArray As $tag){
			
			$tag = trim($tag);
			
			if ( ! in_array($tag, $tags)){
				$tag = Tag::create(['name'=>$tag]);
				$tag->save();			
			}else{
				
				$tag = Tag::where('name',$tag)->first();
			}
			
			$object->tags()->attach($tag);
			
		}
		
		Flash::success('Tagged Successfully!');
		
		return Redirect::back();
	}

}
