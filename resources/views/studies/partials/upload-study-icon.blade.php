<!-- Modal -->
<div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i> Upload New Image for the Study Icon</h4>
      </div>
      <div class="modal-body">
        
      <!-- start body -->
      
      <h2>OPTION 1: Select from the <a href="{!!url('/gallery')!!}">Gallery</a></h2>
      
      <hr>
      <h2>OPTION 2: Upload New Image:</h2>
     	
     	<!-- INCLUDE: studies/forms/change-image.blade.php -->
     	@include('studies.forms.change-image')
     	
     	<!-- end body -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>