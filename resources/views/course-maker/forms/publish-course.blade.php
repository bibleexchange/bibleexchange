<?php 
	if($course->public === 1){
		$publish_course_text = 'make private';
	}else{
		$publish_course_text = 'make public';
	}
?>

{!! Form::open(['url' => '/user/course-maker/'.$course->id.'/publish','class'=>'form-inline','style'=>'display:inline-block']) !!}
   
   {!! Form::submit( $publish_course_text ,['class'=>'btn btn-xs btn-danger','style'=>'display:inline-block;']) !!}

{!! Form::close() !!}