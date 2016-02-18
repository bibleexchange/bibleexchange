<div class="textbook" style="min-height:1200px;">		  
	@include('studies.partials.study')	
</div>			 	
<div class="panel panel-default panel-study-green">
	<div class="panel-heading">
		<h2 class="panel-title">Comments</h2>
	</div>
	<div class="panel-body">
		@if($currentUser)
			@include('partials.forms.comment',['object'=>$study])	
		@endif
		
		@if ($study->comments->isEmpty())
			<p><em class="text-muted">No comments, yet.</em></p>
		@else	
			@include('partials.comments',['commentable'=> $study])
		@endif
	</div>
</div>