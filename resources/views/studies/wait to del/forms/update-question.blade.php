{!! Form::open(['url'=>'/user/study-maker/'.$study->id.'/task/'.$task->model->id.'/update-question']) !!}
	
	{!! Form::hidden('question_id',$question->id) !!}
	{!! Form::text('question',$question->question,['placeholder'=>'question']) !!}
	{!! Form::text('answer',$question->answer,['placeholder'=>'answer']) !!}
	{!! Form::text('readable_answer',$question->readable_answer,['placeholder'=>'readable answer (opt.)']) !!}
	{!! Form::text('options',$question->options,['placeholder'=>'options &quot;+&quot; separated']) !!}
	{!! Form::select('weight',['5'=>'5','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30'],$question->weight) !!}
	{!! Form::select('question_type_id', BibleExchange\Entities\QuestionType::lists('name','id'),$question->question_type_id) !!}
	
	{!! Form::submit('save',['class'=>'btn btn-success btn-xs']) !!}
	
{!! Form::close() !!}