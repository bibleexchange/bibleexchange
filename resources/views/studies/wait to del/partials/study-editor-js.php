<script>
$(window).bind('keydown', function(event) {
	if (event.ctrlKey || event.metaKey) {
		switch (String.fromCharCode(event.which).toLowerCase()) {
			case 's':
				event.preventDefault();
				$('form#studyeditor').submit();
				break;
			case 'f':
				event.preventDefault();
				alert('ctrl-f');
				break;
			case 'g':
				event.preventDefault();
				getContent();
				break;
		}
	}
});
</script>

<script type="text/javascript">
    function getContent(){
        document.getElementById("text").value = document.getElementById("text-1").innerHTML;
    }
</script>