<div id="create-course-action" class="row">
	<div class="col-md-6 col-md-offset-3">
		<button type="button" class="btn btn-primary btn-large" data-toggle="modal" data-target="#createModal">
		 create
		</button>
	</div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i>
         Create new Course</h4>
      </div>
      <div class="modal-body">
		@include('course-maker.forms.create')
     	</div> 
     	<div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>