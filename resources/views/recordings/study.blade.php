<article class="textbook">

	<div class="content">
	
	{!! $study->mainVerse->quote or "" !!}
	
		{!! nl2br(Markdown::convertToHtml($study->text()->text)) !!}

	</div>
	<p>related studies:
	</p>

</article>