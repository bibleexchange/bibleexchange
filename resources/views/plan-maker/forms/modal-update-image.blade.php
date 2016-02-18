<!-- Modal -->
<div class="modal fade" id="updateImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i> Update Course Image</h4>
      </div>
      <div class="modal-body">
        
      <!-- start body -->
      
      <h2>OPTION 1: Use from the <a href="{!!url('/gallery')!!}">Gallery</a></h2>
      
 {!! Form::open(['url'=>'/user/course-maker/'.$course->uuid.'/update-image','files'=>true]) !!}
      <hr>
      <h2>OPTION 2: Upload New Image:</h2>
           	   	
      {!! Form::file('file') !!}
    
      <!-- end body -->
      </div>
      <div class="modal-footer">
         		<button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Save</span>
                </button>
     {!! Form::close() !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>