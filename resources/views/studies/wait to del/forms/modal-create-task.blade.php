<button type="button" class="btn btn-success btn-xs new-task" data-toggle="modal" data-target="#createTaskModal{!!$study->id!!}">
 new Task
</button>

<div class="modal fade" id="createTaskModal{!!$study->id!!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i>
         Create new Task</h4>
      </div>
      <div class="modal-body">
		@include('studies.forms.create-task')
     	</div> 
     	<div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>