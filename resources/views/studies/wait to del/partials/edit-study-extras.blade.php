<div class="edit-study-extras">

<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cTasks" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#cTasks" class="collapsed" aria-expanded="false">Tasks ({!! $study->tasks->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cTasks" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                	<!-- studies.forms.create-task -->
					@include('studies.forms.create-task')
					
					<ul>
					@foreach($study->tasks AS $task)
						<li style="width:100%">
							<a data-toggle="collapse" data-target="#collapse{!!$task->id!!}" >
								<span class="glyphicon glyphicon-task-type-{!!$task->task_type_id!!}"></span>
								{!! $task->taskType->name !!} {!!$task->title!!}
							</a>
							<a class="btn btn-link btn-sm" 
								href="/user/study-maker/{!!$study->id!!}/task/{!!$task->id!!}/edit">editor</a>
							<span id="collapse{!!$task->id!!}" class="collapse">
								<!-- studies.forms.edit-task -->
								@include('studies.forms.edit-task')
							</span>
						</li>
					@endforeach
				</ul>
				
                </div>
            </div>
        </div>
    </div>

<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cTags" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#cTags" class="collapsed" aria-expanded="false">Tags ({!! $study->tags->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cTags" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
				<!-- partials.forms.attach-tags -->
				@include('partials.forms.attach-tags',['object'=>$study,'object_tags_string'=>$study_tags_string])
				
                </div>
            </div>
        </div>
    </div>
	
	<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cVerse" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed" aria-expanded="false">Update Primary Bible Verse ({!! $study->mainVerse->reference  or '' !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cVerse" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
				
				<!-- studies.forms.update-main-verse -->
				@include('studies.forms.update-main-verse')

                </div>
            </div>
        </div>
    </div>
    
	 <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cDescription" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Description <span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cDescription" class="panel-collapse collapse" aria-expanded="true">
                <div class="panel-body">
					
				<!-- studies.forms.update-description -->
				@include('studies.forms.update-description')
					
				</div>
            </div>
        </div>
    </div>
    
   	<div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cIcon" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Recordings ({!! $study->recordings->count() !!})<span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cIcon" class="panel-collapse collapse" aria-expanded="true">
                <div class="panel-body">
					  <h3>Add a recording from the <a href="{!!url('/recordings')!!}">Recordings Archive</a>.</h3>
					  
					  @if($currentUser->can('create_be_recordings'))
					  	<p><a href="/recording/create">Enter</a> a new recording.</p>
					  @endif
					  
					  @foreach ($study->recordings AS $recording)
					  	<!-- INCLUDE: partials.forms.detach-recording-study -->
					  	@include('partials.forms.detach-recording-study',['recording_id'=>$recording->id,'study_id'=>$study->id])
					 	<a style="float:left;" href="{!! $recording->url() !!}">{!! $recording->title !!}</a> 
					  @endforeach
					  
				</div>
            </div>
        </div>
    </div>
	
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#cTips" aria-expanded="false">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Editor & Markdown Tips <span class="caret pull-right"></span></a>
                </h4>
            </div>
            <div id="cTips" class="panel-collapse collapse" aria-expanded="true">
                <div class="panel-body">
                	<!-- INCLUDE: studies.partials.article-tips -->
					@include('studies.partials.article-tips')	
				</div>
            </div>
        </div>
    </div>
    
</div>
<!-- INCLUDE: studies.partials.upload-study-icon -->
@include('studies.partials.upload-study-icon')
<!-- INCLUDE: studies.forms.change-title -->
@include('studies.forms.change-title')
