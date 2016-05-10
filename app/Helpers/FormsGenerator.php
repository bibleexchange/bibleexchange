<?php 
class FormsGenerator 
{
	public static function text($name, $resource, $errors = NULL){
		
		$field = '<!-- '.$name.' START--><div class="form-group ';
		
		if (!is_null($errors)){
			$field .= 'error';
		}else{
			$field .= '';
		}
		
		$field .= '"><label class="col-md-2 control-label" for="name">'.ucfirst($name).'</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="'.$name.'" id="'.$name.'" 
							value="';
		
		if (isset($resource))
		{
			$default = $resource->name;
		}else{
			$default = '';
		}
		
		$field .= Input::old($name, $default) .'" />';
		
		if (!is_null($errors)){
			$field .= '<span class="help-inline">$errors->first($name)</span>'; 
		}
			$field .= '</div></div></div><!-- '.$name.' END-->';
						
		return ($field);
		
	}
}