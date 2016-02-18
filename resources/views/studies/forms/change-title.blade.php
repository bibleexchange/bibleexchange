<!-- Modal -->
<div class="modal fade" id="titleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
        <i class="glyphicon glyphicon-stop"></i>
        CAUTION: Changing Title for Study!</h4>
        <hr>
        <p>Could produce undesired results like breaking external links.</p>
        <p>Use colons (:) exclusively for defining subpages. i.e., The Blood of Jesus: Redemption</p>
      </div>
      <div class="modal-body">
        
      <!-- start body -->
      
      {!! Form::open(['url'=>'/user/study-maker/'.$study->id.'/edit-title','class'=>'form-inline']) !!}
		<div class="form-group">
	        <label class="control-label" for="title">Title: &nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="title" id="title" value="{!! $study->present()->title !!}" style="width:400px">
		</div>

      <!-- end body -->
      </div>
      <div class="modal-footer">
    	{!! Form::submit('save',['class'=>'btn btn-primary start']) !!}
		{!! $errors->first('title', '<span class="help-block">:message</span>') !!}
     {!! Form::close() !!}
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>