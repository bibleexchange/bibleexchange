	<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal">
	 change title
	</button>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i>
         Delete Recording</h4>
         
         <hr>
         
         <p>WARNING: This will delete the recording and all properties associated with it. It will not be recoverable.</p>
      </div>
      <div class="modal-body">
        
		@include('partials.forms.delete-recording',['recording_id'=>$recording->id])
     	</div> 
     	<div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>