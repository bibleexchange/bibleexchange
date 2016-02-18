<div class="edit-study-extras">

	<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cTags" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#cTags" class="collapsed" aria-expanded="false">Tags ({!! $recording->tags->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cTags" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">

				@include('partials.forms.attach-tags',['object'=>$recording,'object_tags_string'=>$recording_tags_string])
				
                </div>
            </div>
        </div>
    </div>

	<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cFormats" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed" aria-expanded="false">Recording Formats ({!! $recording->formats->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cFormats" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">

					@include('partials.forms.add-recording-format',['recording_id'=>$recording->id])
					
					@include('recordings.partials.recordings-stream',['recording'=>$recording])
					
                </div>
            </div>
        </div>
    </div>

	<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cVerse" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed" aria-expanded="false">Scriptures ({!! $recording->verses->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cVerse" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">

					@include('partials.forms.add-scripture-to-recording',['recording_id'=>$recording->id])
					<hr>
					@foreach($recording->verses AS $verse)
						@include('partials.forms.detach-recording-verse',['recording_id'=>$recording->id, 'verse_id'=>$verse->id])
						{!! $verse->quote !!}
					@endforeach
					
                </div>
            </div>
        </div>
    </div>
    
	 <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cDescription" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">People ({!! $recording->persons->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cDescription" class="panel-collapse collapse" aria-expanded="true">
                <div class="panel-body">
					
					@include('partials.forms.attach-recording-person',['recording_id'=>$recording->id, 'persons'=>$persons])
					<hr>
					@foreach($recording->persons AS $person)
						@include('partials.forms.detach-recording-person',['recording_id'=>$recording->id, 'person_id'=>$person->id])
						{!! $person->fullname !!} [{!! $person->pivot->role !!}] | 
					@endforeach
					
				</div>
            </div>
        </div>
    </div>
    
</div>
