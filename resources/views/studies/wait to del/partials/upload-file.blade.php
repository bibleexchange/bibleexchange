<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i>
         Upload Markdown File (.md)</h4>
         
         <hr>
         
         <p>Uploaded text from file will replace all text in your form, but the changes will not take effect unti you save the editor form.</p>
      </div>
      <div class="modal-body">
        
      <!-- start body -->
      
      <?php 
      	///url('/user/study-maker/'.$study->id.'/upload-text-file')
      ?>
      
      {!! Form::open(['url'=>url('/user/study-maker/upload-text-file'),'files'=>true]) !!}
      
      	{!! Form::file('file') !!}
    
      <!-- end body -->
      </div>
      <div class="modal-footer">
         		<button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Upload</span>
                </button>
     {!! Form::close() !!}
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>