<ul id="notebooksList">
	
	@foreach($notebooks AS $notebook)

		<li>
			<a href="/user/content/evernote/{{$notebook->getGuid() }}">
				{{ $notebook->getName() }}
			</a>
		</li>
		
	@endforeach

	</ul>