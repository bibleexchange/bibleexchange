{!! Form::open(['url'=>'/user/study-maker/'.$study->id.'/task/'.$task->model->id.'/store-question']) !!}
	
	{!! Form::text('question',null,['placeholder'=>'question']) !!}
	{!! Form::text('answer',null,['placeholder'=>'answer']) !!}
	{!! Form::text('readable_answer',null,['placeholder'=>'readable answer (opt.)']) !!}
	{!! Form::text('options',null,['placeholder'=>'options &quot;+&quot; separated']) !!}
	{!! Form::select('weight',['5'=>'5','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30']) !!}
	{!! Form::select('question_type_id', BibleExchange\Entities\QuestionType::lists('name','id')) !!}
	
	{!! Form::submit('new',['class'=>'btn btn-xs btn-primary']) !!}
	
{!! Form::close() !!}