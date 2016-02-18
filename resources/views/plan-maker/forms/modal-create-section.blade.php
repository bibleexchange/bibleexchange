<div id="create-section-action" class="row">
	<div class="col-md-6 col-md-offset-3">
		<button type="button" class="btn btn-info btn-large" data-toggle="modal" data-target="#createSectionModal">
		 create new Section
		</button>
	</div>
</div>

<div class="modal fade" id="createSectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i>
         Create new Section</h4>
      </div>
      <div class="modal-body">
		@include('course-maker.forms.create-section')
     	</div> 
     	<div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>