<h2><button class="btn btn-md btn-default" data-toggle="collapse" data-target="#makeNote"><span class="glyphicon glyphicon-plus"></span></button> Notes</h2>
<div id="feed">
	
	<div id="makeNote" class="collapse">
		@include('notes.partials.publish-scripture-note-form')
	</div>
	
	@include('notes.partials.notes')
</div>