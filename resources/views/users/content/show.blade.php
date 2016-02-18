<h1>{{ $notebook->getName() }} ({{$notesInNotebook->totalNotes}} notes)</h1>

<ul id="notesList">
	
	@foreach($notesInNotebook->notes AS $note)
	
		<li>
			<a href="/user/content/evernote/note/{{$note->guid }}">
				{{ $note->title }}
			</a>
		</li>
		
	@endforeach

	</ul>